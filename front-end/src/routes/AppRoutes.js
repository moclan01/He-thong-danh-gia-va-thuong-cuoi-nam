import React from 'react';
import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import Login from '../pages/Login';
import Home from '../pages/Home';
import Profile from '../pages/Profile';
import ChangePassword from '../pages/ChangePassword';
import SelfAssessment from '../pages/evaluation/SelfAssessment';
import Logout from '../pages/Logout';
import CriteriaManage from '../pages/evaluation/EvaluationCriteriaManage';
import AddCriteria from '../pages/evaluation/AddCriteria';
import UpdateCriteria from '../pages/evaluation/UpdateCriteria';
import CriteriaQuestions from '../pages/evaluation/EvaluationQuestions';
import AddQuestion from '../pages/evaluation/AddEvaluationQuestion';
import UpdateQuestion from '../pages/evaluation/UpdateEvaluationQuestion';

export default function AppRoute() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Navigate to="/login" />} />
        <Route path="/login" element={<Login />} />
        <Route path="/logout" element={<Logout />} />
        <Route path="/home" element={<Home />} />
        <Route path="/profile" element={<Profile />} />
        <Route path='/change-password' element={<ChangePassword />} />
        <Route path="/self-assessment" element={<SelfAssessment />} />
        <Route path='/criteria-management' element={<CriteriaManage />} />
        <Route path='/criteria/add' element={<AddCriteria />} />
        <Route path='/criteria/update/:id' element={<UpdateCriteria />} />
        <Route path="/criterias/:id/questions" element={<CriteriaQuestions />} />
        <Route path="/questions/add/:criteriaId" element={<AddQuestion />} />
        <Route path="/questions/update/:id" element={<UpdateQuestion />} />
        {/* Thêm các route khác ở đây */}
      </Routes>
    </Router>
  );
}
