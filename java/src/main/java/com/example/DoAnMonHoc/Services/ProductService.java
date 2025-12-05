package com.example.DoAnMonHoc.Services;

import com.example.DoAnMonHoc.Models.Product;
import org.springframework.stereotype.Service;

import java.util.List;


public interface ProductService {
    List<Product> getAll();
    Product addProduct(Product product);
}
