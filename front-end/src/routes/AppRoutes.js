import React from 'react';
import { Routes, Route } from 'react-router-dom';
import PlantList from '../pages/plant/PlantList';

const AppRoutes = () => {
  const user = getCurrentUser();
  return React.createElement(
    Routes,
    null,
    React.createElement(Route, {
      path: '/login',
      element: user ? React.createElement(() => { window.location.href = '/'; return null; }) : React.createElement(Login),
    }),
    React.createElement(Route, {
      path: '/',
      element: user ? React.createElement(Home) : React.createElement(() => { window.location.href = '/login'; return null; }),
    }),
    React.createElement(Route, {
      path: '/plants',
      element: user ? React.createElement(PlantList) : React.createElement(() => { window.location.href = '/login'; return null; }),
    }),
    React.createElement(Route, { path: '*', element: React.createElement('div', null, '404 Not Found') })
  );
};

export default AppRoutes;