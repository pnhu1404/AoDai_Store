package com.example.DoAnMonHoc.Services;

import com.example.DoAnMonHoc.Models.Product;
import com.example.DoAnMonHoc.Repositories.ProductRepository;
import lombok.AllArgsConstructor;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
@AllArgsConstructor
public class ProductService {
    private final ProductRepository productRepository;

    public List<Product> getAll(){
        return productRepository.findAll();
    }
    public Product addProduct(Product product){
        return productRepository.save(product);
    }
}
