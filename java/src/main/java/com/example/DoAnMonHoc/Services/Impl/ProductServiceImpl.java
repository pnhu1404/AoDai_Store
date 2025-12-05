package com.example.DoAnMonHoc.Services.Impl;

import com.example.DoAnMonHoc.Models.Product;
import com.example.DoAnMonHoc.Repositories.ProductRepository;
import com.example.DoAnMonHoc.Services.ProductService;
import lombok.AllArgsConstructor;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
@AllArgsConstructor
public class ProductServiceImpl implements ProductService {
    private final ProductRepository productRepository;

    @Override
    public List<Product> getAll(){
        return productRepository.findAll();
    }

}
