import "../css/style.css";

export default function Home() {
  const products = [
    {
      id: 1,
      name: "Áo Dài Truyền Thống",
      price: "1.200.000đ",
      img: "https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Aodai_3.jpg/640px-Aodai_3.jpg"
    },
    {
      id: 2,
      name: "Áo Dài Cách Tân",
      price: "950.000đ",
      img: "https://upload.wikimedia.org/wikipedia/commons/thumb/8/81/Aodai_modern.jpg/640px-Aodai_modern.jpg"
    },
    {
      id: 3,
      name: "Áo Dài Cưới",
      price: "2.900.000đ",
      img: "https://upload.wikimedia.org/wikipedia/commons/thumb/e/e4/Ao_dai_wedding.jpg/640px-Ao_dai_wedding.jpg"
    },
    {
      id: 4,
      name: "Áo Dài Học Sinh",
      price: "700.000đ",
      img: "https://upload.wikimedia.org/wikipedia/commons/thumb/2/26/Vietnamese_schoolgirls_ao_dai.jpg/640px-Vietnamese_schoolgirls_ao_dai.jpg"
    },
  ];

  return (
    <div className="container py-4">
      <h3 className="mb-4">Sản phẩm nổi bật</h3>

      <div className="row g-4">
        {products.map((p) => (
          <div className="col-md-3" key={p.id}>
            <div className="card product-card">
              <img src={p.img} alt={p.name} className="card-img-top" />

              <div className="card-body">
                <h5 className="card-title">{p.name}</h5>
                <p className="text-danger fw-bold">{p.price}</p>
                <button className="btn btn-outline-danger w-100">
                  Xem chi tiết
                </button>
              </div>

            </div>
          </div>
        ))}
      </div>
    </div>
  );
}
