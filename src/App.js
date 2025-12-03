import './App.css';
import Header from './components/Header';
import Sidebar from './components/Sidebar';
import Footer from './components/Footer';
import Home from './pages/Home';

function App() {
  return (
    <div className="d-flex">
      <Sidebar />
      <div className="flex-grow-1 d-flex flex-column">
        <Header />
        <Home />
        <Footer />
      </div>
    </div>
  );
}

export default App;
