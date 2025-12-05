package com.example.DoAnMonHoc.Services.Impl;

import com.example.DoAnMonHoc.Models.User;
import com.example.DoAnMonHoc.Repositories.UserRepository;
import com.example.DoAnMonHoc.Services.UserService;
import lombok.AllArgsConstructor;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;

@Service
@AllArgsConstructor
public class UserServiceImpl implements UserService {
    private final UserRepository userRepository;
    private final PasswordEncoder passwordEncoder;

    @Override
    public User login(User user) {

        User userLogin = userRepository.findByUsername(user.getUsername());

        if (userLogin == null) {
            throw new RuntimeException("Username không tồn tại");
        }

        if (!passwordEncoder.matches(user.getPasswordHash(),userLogin.getPasswordHash())) {
            throw new RuntimeException("Sai mật khẩu");
        }

        return userLogin;  // hoặc trả JWT sau
    }

}
