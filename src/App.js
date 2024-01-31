import React from 'react';
import DenseTable from './components/TabelaVendasWhats';
import IntervaloSelector from './components/IntervaloSelector';
import './styles.css';
import TabelaVendasVideo from './components/TabelaVendasVideo';
import TabelaVendasWhats from './components/TabelaVendasWhats';
import TabelaVendasTotal from './components/TabelaVendasTotal';

function App() {
  return (
    <div className='App'>
      
      <IntervaloSelector />
      <div className='table-spacing'></div>
      <TabelaVendasWhats className='table-vendas-whats'/>
      <div className='table-spacing'></div>
      <TabelaVendasVideo />
      <div className='table-spacing'></div>
      <TabelaVendasTotal />
      
    </div>
  );
}

export default App;
