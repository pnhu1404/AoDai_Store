package com.example.DoAnMonHoc.Models;

import jakarta.persistence.*;
import lombok.*;

@Entity
@Table(name = "user")
@Data
@NoArgsConstructor
@AllArgsConstructor
public class User {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "user_id") // BẮT BUỘC: Ánh xạ từ userId sang user_id
    private Integer userId;

    @Column(name = "username")
    private String username;

    @Column(name = "fullname")
    private String fullname;

    @Column(name = "email")
    private String email;

    @Column(name = "password_hash") // BẮT BUỘC: Ánh xạ từ passwordHash sang password_hash
    private String passwordHash;

    @Column(name = "phone")
    private String phone;

    @Column(name = "address")
    private String address;

    @Column(name = "role")
    private Integer role;
}
