import './App.css'
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Nav from './components/Nav';
import Home from './pages/Home';
function App() {

  return (
    <>
      <Nav></Nav>
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<Home />} />
        </Routes>

      </BrowserRouter>
    </>
  )
}

export default App
