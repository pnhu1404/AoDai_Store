package com.example.DoAnMonHoc.Controllers;

import com.example.DoAnMonHoc.Models.Product;
import com.example.DoAnMonHoc.Services.Impl.ProductServiceImpl;
import com.example.DoAnMonHoc.Services.ProductService;
import lombok.AllArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@AllArgsConstructor
@CrossOrigin(origins = "*")
@RequestMapping("/product")
public class ProductController {

    private final ProductService productService;

    @GetMapping
    public List<Product> getAll(){
        return productService.getAll();
    }

    @PostMapping("/addProduct")
    public ResponseEntity<?> addProduct(@RequestBody Product product){

        return ResponseEntity.ok(productService.addProduct(product));
    }

}
