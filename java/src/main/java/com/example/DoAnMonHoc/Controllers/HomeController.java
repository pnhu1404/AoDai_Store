package com.example.DoAnMonHoc.Controllers;


import com.example.DoAnMonHoc.Services.CategoryService;
import com.example.DoAnMonHoc.Services.ProductService;
import lombok.AllArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.HashMap;
import java.util.Map;

@RestController
@RequestMapping("/")
@CrossOrigin(origins = "*")
@AllArgsConstructor
public class HomeController {

    private final ProductService productService;
    private final CategoryService categoryService;

    @GetMapping
    public ResponseEntity<?> home(){
        Map<String,Object> responseData= new HashMap<>();

        responseData.put("products",productService.getAll());
        responseData.put("categories",productService.getAll());

        return ResponseEntity.ok(responseData);
    }
}
