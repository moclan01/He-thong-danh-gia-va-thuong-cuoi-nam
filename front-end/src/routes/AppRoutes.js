import React from 'react';
import { Routes, Route } from 'react-router-dom';
import PlantList from '../pages/plant/PlantList';

const AppRoutes = () => {
  return React.createElement(
    Routes,
    null,
    React.createElement(Route, { path: '/plants', element: React.createElement(PlantList) }),
    React.createElement(Route, { path: '*', element: React.createElement('div', null, '404 Not Found') })
  );
};

export default AppRoutes;