import './App.css';
import Header from './components/Header';
import Sidebar from './components/Sidebar';
import Footer from './components/Footer';
import Home from './pages/Home';
import { Route, Routes } from 'react-router';
import Detail from './pages/Detail';
function App() {
  return (
    <div className="app-wrapper d-flex"> 
      <Sidebar />
      <div className="main-layout flex-grow-1 d-flex flex-column">
        <Header />
        <div className="main-content flex-grow-1">
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="/detail/:id" element={<Detail />} /> 
          </Routes>
        </div>
        <Footer />
      </div>
    </div>
  );
}

export default App;
