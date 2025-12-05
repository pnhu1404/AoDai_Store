package com.example.DoAnMonHoc.Controllers;

import com.example.DoAnMonHoc.Models.User;
import com.example.DoAnMonHoc.Services.UserService;
import lombok.AllArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@AllArgsConstructor
@CrossOrigin(origins = "http://localhost:8080/auth")
@RequestMapping("/auth")
public class AuthController {
    private final UserService userService;

    @PostMapping("/login")
    public ResponseEntity<User> login(@RequestBody User user){
        User userLogin=userService.login(user);


        return ResponseEntity.ok(userLogin);

    }
}
