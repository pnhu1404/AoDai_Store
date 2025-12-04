import React from 'react';
import { Link } from 'react-router';

function ProductCard({ product, onAddToCart }) {
  // Giả định product có { id, name, price, slug }
  return (
    <div className="col-lg-3 col-md-6 col-sm-12 mb-4">
      <div className="card h-100 shadow-sm border-0">
        
        {/* Liên kết đến trang chi tiết sản phẩm */}
        <Link to={`/product/${product.slug}`} className="text-decoration-none text-dark">
            <img 
              src={'https://via.placeholder.com/300x400?text=' + product.name.replace(/\s/g, '+')} 
              className="card-img-top" 
              alt={product.name} 
              style={{ height: '300px', objectFit: 'cover' }}
            />
        </Link>
        
        <div className="card-body d-flex flex-column">
          <Link to={`/product/${product.slug}`} className="text-decoration-none text-dark">
             <h5 className="card-title">{product.name}</h5>
          </Link>

          <p className="card-text text-danger fw-bold mt-auto">
            {product.price.toLocaleString()} VNĐ
          </p>
          
          <button 
            className="btn btn-danger mt-3" 
            onClick={() => onAddToCart(product)}
          >
            Thêm vào giỏ
          </button>
        </div>
      </div>
    </div>
  );
}

export default ProductCard;