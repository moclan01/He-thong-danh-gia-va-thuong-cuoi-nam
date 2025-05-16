import React from 'react';
import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import Login from '../pages/Login';
import Home from '../pages/Home';
import Profile from '../pages/Profile';
import ChangePassword from '../pages/ChangePassword';
import Logout from '../pages/Logout';
import CriteriaManage from '../pages/evaluation/EvaluationCriteriaManage';
import AddCriteria from '../pages/evaluation/AddCriteria';
import UpdateCriteria from '../pages/evaluation/UpdateCriteria';
import CriteriaQuestions from '../pages/evaluation/EvaluationQuestionsManage';
import AddQuestion from '../pages/evaluation/AddQuestion';
import UpdateQuestion from '../pages/evaluation/UpdateQuestion';
import CycleManage from '../pages/evaluation/EvaluationCycleManage';
import AddCycle from '../pages/evaluation/AddCycle';
import UpdateCycle from '../pages/evaluation/UpdateCycle';
import CriteriaFormManage from '../pages/evaluation/EvaluationFormManage';
import AddForm from '../pages/evaluation/AddForm';
import CriteriaFormDetail from '../pages/evaluation/CriteriaFormDetail';
import EmployeeSelfEvaluation from '../pages/SelfAssessment';
import EvaluationHistory from '../pages/EvaluationHistory';


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
        <Route path='/criteria-management' element={<CriteriaManage />} />
        <Route path='/criteria/add' element={<AddCriteria />} />
        <Route path='/criteria/update/:id' element={<UpdateCriteria />} />
        <Route path="/criterias/:id/questions" element={<CriteriaQuestions />} />
        <Route path="/questions/add/:criteriaId" element={<AddQuestion />} />
        <Route path="/questions/update/:id" element={<UpdateQuestion />} />
        <Route path='/cycle-management' element={<CycleManage />} />
        <Route path='/cycle/add' element={<AddCycle />} />
        <Route path='/cycle/update/:id' element={<UpdateCycle />} />
        <Route path='/form-management' element={<CriteriaFormManage />} />
        <Route path='/form/add' element={<AddForm />} />
        <Route path='/form-management/detail/:formId' element={<CriteriaFormDetail />} />
        <Route path='/self-assessment' element={<EmployeeSelfEvaluation />} />
        <Route path='/evaluation-history' element={<EvaluationHistory />} />

        {/* Thêm các route khác ở đây */}
      </Routes>
    </Router>
  );
}
