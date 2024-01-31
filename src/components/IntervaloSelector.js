import React from 'react';

const IntervaloSelector = ({ onIntervalChange }) => {
  const handleButtonClick = (intervalo) => {
    onIntervalChange(intervalo);
  };

  return (
    <div>
      {/* Botões para escolher o intervalo */}
      <button onClick={() => handleButtonClick('semana')}>Semana</button>
      <button onClick={() => handleButtonClick('mes')}>Mês</button>
      <button onClick={() => handleButtonClick('ano')}>Ano</button>
    </div>
  );
};

export default IntervaloSelector;
