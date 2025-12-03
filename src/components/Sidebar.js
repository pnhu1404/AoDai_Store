import "../css/style.css";

export default function Sidebar() {
  return (
    <div className="custom-sidebar">
      <ul className="list-group list-group-flush">
        <li className="list-group-item"> Trang chủ</li>
        <li className="list-group-item"> Sản phẩm</li>
        <li className="list-group-item"> Khuyến mãi</li>
        <li className="list-group-item"> Đơn hàng</li>
        <li className="list-group-item"> Liên hệ</li>
      </ul>
    </div>
  );
}
