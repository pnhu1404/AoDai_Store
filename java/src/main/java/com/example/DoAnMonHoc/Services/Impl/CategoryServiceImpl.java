package com.example.DoAnMonHoc.Services.Impl;

import com.example.DoAnMonHoc.Models.Category;
import com.example.DoAnMonHoc.Repositories.CategoryRepository;
import com.example.DoAnMonHoc.Services.CategoryService;
import lombok.AllArgsConstructor;
import org.springframework.stereotype.Service;

import java.util.List;

@AllArgsConstructor
@Service
public class CategoryServiceImpl implements CategoryService {
    private final CategoryRepository categoryRepository;

    @Override
    public List<Category> getAll(){
        return categoryRepository.findAll();
    }
}
