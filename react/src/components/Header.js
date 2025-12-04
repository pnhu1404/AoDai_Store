export default function Header() {
  return (
    <nav className="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 py-3">
      <a className="navbar-brand fw-bold text-danger fs-4" href="#">
        Áo Dài Store
      </a>
      
      <div className="collapse navbar-collapse" id="menu">
        <div className="ms-auto d-flex align-items-center gap-2">
          <button className="btn btn-outline-danger">Đăng nhập</button>
          <button className="btn btn-danger">
            <i className="bi bi-cart3 me-1"></i>
            Giỏ hàng
          </button>
        </div>
      </div>
    </nav>
  );
}
