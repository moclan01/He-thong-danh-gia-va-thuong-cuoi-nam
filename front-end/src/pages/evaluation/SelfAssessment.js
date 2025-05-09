import React, { useState, useEffect } from 'react';
import axiosInstance from '../../services/axiosInstance';
import { useNavigate } from 'react-router-dom';

 function SelfAssessment() {
  const [assessmentData, setAssessmentData] = useState([]);
  const [employeeRole, setEmployeeRole] = useState(null); 
  const [error, setError] = useState('');
  const navigate = useNavigate();

  useEffect(() => {
    const user = JSON.parse(localStorage.getItem('user'));
    if (user) {
      setEmployeeRole(user.role);  
    } else {
      navigate('/login');
    }

    axiosInstance.get('/self-assessment')
      .then(res => setAssessmentData(res.data))
      .catch(err => setError('Không thể tải dữ liệu đánh giá'));
  }, [navigate]);

  const handleSave = () => {
    console.log('Lưu đánh giá:', assessmentData);
  };

  const handleInputChange = (index, field, value) => {
    const newAssessmentData = [...assessmentData];
    newAssessmentData[index][field] = value;
    setAssessmentData(newAssessmentData);
  };

  return (
    <div className="container mt-5">
      <h2>Tự đánh giá</h2>
      {error && <div className="alert alert-danger">{error}</div>}
      <table className="table">
        <thead>
          <tr>
            <th>Nội dung</th>
            <th>Điểm tối đa</th>
            <th>Nhân viên</th>
            <th>Quản lý</th>
            <th>Supervisor</th>
            <th>Giám đốc</th>
          </tr>
        </thead>
        <tbody>
          {assessmentData.map((item, index) => (
            <tr key={index}>
              <td>{item.content}</td>
              <td>{item.max_score}</td>
              <td>
                {employeeRole === 'employee' ? (
                  <input
                    type="number"
                    value={item.employee_score || ''}
                    onChange={(e) => handleInputChange(index, 'employee_score', e.target.value)}
                    className="form-control"
                    disabled={employeeRole !== 'employee'}
                  />
                ) : null}
              </td>
              <td>
                {employeeRole === 'manager' ? (
                  <input
                    type="number"
                    value={item.manager_score || ''}
                    onChange={(e) => handleInputChange(index, 'manager_score', e.target.value)}
                    className="form-control"
                    disabled={employeeRole !== 'manager'}
                  />
                ) : null}
              </td>
              <td>
                {employeeRole === 'supervisor' ? (
                  <input
                    type="number"
                    value={item.supervisor_score || ''}
                    onChange={(e) => handleInputChange(index, 'supervisor_score', e.target.value)}
                    className="form-control"
                    disabled={employeeRole !== 'supervisor'}
                  />
                ) : null}
              </td>
              <td>
                {employeeRole === 'director' ? (
                  <input
                    type="number"
                    value={item.director_score || ''}
                    onChange={(e) => handleInputChange(index, 'director_score', e.target.value)}
                    className="form-control"
                    disabled={employeeRole !== 'director'}
                  />
                ) : null}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
      <button className="btn btn-primary" onClick={handleSave}>Lưu</button>
    </div>
  );
}
export default SelfAssessment;