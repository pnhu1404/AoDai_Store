package com.example.DoAnMonHoc.Controllers;

import com.example.DoAnMonHoc.Models.Product;
import com.example.DoAnMonHoc.Services.ProductService;
import lombok.AllArgsConstructor;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.List;

@RestController
@AllArgsConstructor
@CrossOrigin(origins = "*")
@RequestMapping("/product")
public class ProductController {

    private final ProductService   productService;

    @GetMapping
    public List<Product> getAll(){
        return productService.getAll();
    }

}
