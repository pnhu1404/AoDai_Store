package com.example.DoAnMonHoc.Services.Impl;

import com.example.DoAnMonHoc.Models.User;
import com.example.DoAnMonHoc.Repositories.UserRepository;
import lombok.AllArgsConstructor;

@AllArgsConstructor
public class UserServiceImpl {
    private final UserRepository userRepository;

    public User login(User user) {

        User userLogin = userRepository.findByUsername(user.getUsername());

        if (userLogin == null) {
            throw new RuntimeException("Username không tồn tại");
        }

        if (!userLogin.getPasswordHash().equals(user.getPasswordHash())) {
            throw new RuntimeException("Sai mật khẩu");
        }

        return userLogin;  // hoặc trả JWT sau
    }

}
