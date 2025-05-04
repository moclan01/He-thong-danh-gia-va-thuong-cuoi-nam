import React from 'react';
import './App.css';
import { BrowserRouter } from 'react-router-dom';
import AppRoutes from './routes/AppRoutes';
import './styles/custom.css';

function App() {
  return React.createElement(
    BrowserRouter,
    null,
    React.createElement(
      'div',
      { className: 'min-vh-100 bg-light' },
      React.createElement(AppRoutes)
    )
  );
}

export default App;
