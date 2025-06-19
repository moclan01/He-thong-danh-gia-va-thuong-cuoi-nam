import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import axiosInstance from '../../services/axiosInstance';
import MainLayout from "../MainLayout";

const WhatFormManage = () => {
  const navigate = useNavigate();
  const [whatForms, setWhatForms] = useState([]);
  const [evaluationCycles, setEvaluationCycles] = useState([]);
  const [departments, setDepartments] = useState([]);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [isViewModalOpen, setIsViewModalOpen] = useState(false);
  const [selectedWhatForm, setSelectedWhatForm] = useState(null);
  const [formData, setFormData] = useState({
    evaluation_cycle_id: '',
    what_form_name: '',
    total_weighting: '',
    total_score: null,
    status: 'active',
    items: [{ name: '', weighting: '', target: '', actual: '', m: '', n: '', comments: '', FY_target: '' }],
  });

  useEffect(() => {
    fetchWhatForms();
    fetchEvaluationCycles();
    fetchDepartments();
  }, []);

  const fetchWhatForms = async () => {
    try {
      const response = await axiosInstance.get('/what-forms');
      setWhatForms(response.data.data || response.data);
    } catch (error) {
      console.error('Lỗi khi lấy WhatForms:', error);
      alert('Lỗi khi lấy danh sách WhatForm');
    }
  };

  const fetchEvaluationCycles = async () => {
    try {
      const response = await axiosInstance.get('/evaluation-cycles');
      setEvaluationCycles(response.data);
    } catch (error) {
      console.error('Lỗi khi lấy Evaluation Cycles:', error);
      alert('Lỗi khi lấy danh sách chu kỳ đánh giá');
    }
  };

  const fetchDepartments = async () => {
    try {
      const response = await axiosInstance.get('/departments');
      setDepartments(response.data);
    } catch (error) {
      console.error('Lỗi khi lấy Departments:', error);
      alert('Lỗi khi lấy danh sách phòng ban');
    }
  };

  const getDepartmentName = (departmentId) => {
    const department = departments.find(dep => dep.department_id === departmentId);
    return department ? department.department_name : 'N/A';
  };

  const getCycleName = (cycleId) => {
    const cycle = evaluationCycles.find(c => c.evaluation_cycle_id === cycleId);
    return cycle ? cycle.cycle_name : 'N/A';
  };

  return (
    <MainLayout>

    </MainLayout>
  );

}

export default WhatFormManage;