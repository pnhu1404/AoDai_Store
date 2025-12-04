package com.example.DoAnMonHoc.Services;

import com.example.DoAnMonHoc.Models.User;
import org.springframework.stereotype.Service;

@Service
public interface UserService {
    User login(User user);
}
