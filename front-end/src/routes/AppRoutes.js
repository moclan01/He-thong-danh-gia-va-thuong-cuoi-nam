import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Login from '../pages/Login';
import Home from '../pages/Home';
import Profile from '../pages/Profile';
import ChangePassword from '../pages/ChangePassword';
import SelfAssessment from '../pages/evaluation/SelfAssessment';

export default function AppRoute() {
  return (
    <Router>
      <Routes>
        <Route path="/login" element={<Login />} />
        <Route path="/home" element={<Home />} />
        <Route path="/profile" element={<Profile />} />
        <Route path='/change-password' element={<ChangePassword />} />
        <Route path="/self-assessment" element={<SelfAssessment />} />
        {/* <Route path="/evaluation-results" element={<EvaluationResults />} />
        <Route path="/evaluation-history" element={<EvaluationHistory />} /> */}
        {/* Thêm các route khác ở đây */}
      </Routes>
    </Router>
  );
}
