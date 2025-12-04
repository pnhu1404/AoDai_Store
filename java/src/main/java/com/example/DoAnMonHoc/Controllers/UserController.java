package com.example.DoAnMonHoc.Controllers;

import com.example.DoAnMonHoc.Models.User;
import com.example.DoAnMonHoc.Repositories.UserRepository;
import lombok.NoArgsConstructor;
import org.apache.coyote.Request;
import org.springframework.web.bind.annotation.*;

import java.util.List;


@CrossOrigin(origins = "*")
@RestController
@RequestMapping("/user")
public class UserController {
    private final UserRepository a;

    public UserController (UserRepository userRepository){
        this.a=userRepository;
    }

    @GetMapping
    public List<User> getAll(){
        List<User> userList= a.findAll();
        return userList;
    }

    @PostMapping("/add")
    public User addUser(@RequestBody User user){

        return a.save(user);
    }

}
