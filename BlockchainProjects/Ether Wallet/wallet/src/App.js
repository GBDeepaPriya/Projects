//import logo from './logo.svg';
import './App.css';
import {BrowserRouter, Route, Routes} from "react-router-dom";
import Createwallet from './pages/createwallet';
import LoginWallet from './pages/loginwallet';
import Home from './pages/home';
import Sendth from './pages/sendeth';


function App() {
  return (
    <div className="App">
     <BrowserRouter>
    <Routes>
    <Route path='/home' element={<Home/>} />
      <Route path='/login' element={<LoginWallet/>} />
      <Route path='/create' element={<Createwallet/>} />
      <Route path='/send' element={<Sendth/>} />
    </Routes>
    </BrowserRouter> 
    </div>
  );
}

export default App;