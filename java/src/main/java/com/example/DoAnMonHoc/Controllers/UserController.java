package com.example.DoAnMonHoc.Controllers;

import com.example.DoAnMonHoc.Models.User;
import com.example.DoAnMonHoc.Repositories.UserRepository;
import lombok.AllArgsConstructor;
import lombok.NoArgsConstructor;
import org.apache.coyote.Request;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.web.bind.annotation.*;

import java.util.List;


@CrossOrigin(origins = "*")
@RestController
@RequestMapping("/user")
@AllArgsConstructor
public class UserController {
    private final UserRepository a;
    private final PasswordEncoder passwordEncoder;



    @GetMapping
    public List<User> getAll(){
        List<User> userList= a.findAll();
        return userList;
    }

    @PostMapping("/add")
    public User addUser(@RequestBody User user){
        String hash=passwordEncoder.encode(user.getPasswordHash());
        user.setPasswordHash(hash);
        return a.save(user);
    }

}
