package com.example.DoAnMonHoc.Services;


import com.example.DoAnMonHoc.Models.Category;

import java.util.List;

public interface CategoryService {
    List<Category> getAll();
    Category addCategory(Category category);
}
