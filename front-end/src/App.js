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
      null,
      React.createElement(Header),
      React.createElement(
        'div',
        { className: 'd-flex' },
        React.createElement(Sidebar),
        React.createElement(
          'div',
          { className: 'flex-grow-1 p-4' },
          React.createElement(AppRoutes)
        )
      )
    )
  );
}

export default App;
