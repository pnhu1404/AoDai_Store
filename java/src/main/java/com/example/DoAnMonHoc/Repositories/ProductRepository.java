package com.example.DoAnMonHoc.Repositories;

import com.example.DoAnMonHoc.Models.Product;
import org.springframework.data.jpa.repository.JpaRepository;

public interface ProductRepository extends JpaRepository<Product,Integer> {
}
