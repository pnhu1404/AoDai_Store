import React from "react";
import "../css/detail.css";

const Detail = () => {
  const product = {
    name: "Áo Dài Truyền Thống",
    price: 799000,
    oldPrice: 950000,
    img: "https://i.imgur.com/QNqQdZR.jpeg",
    desc: "Chất liệu cao cấp, đường may tinh xảo, phù hợp đi tiệc, lễ hội, chụp ảnh cưới."
  };

  return (
    <div className="detail-wrapper">
      <div className="detail-left">
        <img src={product.img} alt={product.name} className="detail-img" />
      </div>

      <div className="detail-right">
        <h2 className="detail-title">{product.name}</h2>

        <div className="detail-price-box">
          <span className="detail-price">
            {product.price.toLocaleString()}đ
          </span>
          <span className="detail-oldprice">
            {product.oldPrice.toLocaleString()}đ
          </span>
        </div>

        <p className="detail-desc">{product.desc}</p>

        <div className="detail-select">
          <label>Size</label>
          <select>
            <option>S</option>
            <option>M</option>
            <option>L</option>
            <option>XL</option>
          </select>
        </div>

        <button className="detail-btn">Thêm vào giỏ</button>
      </div>
    </div>
  );
};

export default Detail;
