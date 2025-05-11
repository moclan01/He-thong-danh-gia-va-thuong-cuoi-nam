import React, { useState } from 'react';
import axiosInstance from '../services/axiosInstance';
import Sidebar from '../components/Sidebar';
import { useNavigate } from 'react-router-dom';

function ChangePassword() {
  const navigate = useNavigate();
  const [form, setForm] = useState({
    current_password: '',
    new_password: '',
    new_password_confirmation: '',
  });

  const [message, setMessage] = useState('');
  const [error, setError] = useState('');

  const handleChange = e => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async e => {
    e.preventDefault();
    setMessage('');
    setError('');

    try {
      const res = await axiosInstance.post('/employee/change-password', form);
      setMessage(res.data.message || 'Đổi mật khẩu thành công');

      setTimeout(() => {
        // axiosInstance.post('/logout').finally(() => {
        //   localStorage.removeItem('token');
        //   localStorage.removeItem('user');
        //   navigate('/login');
        // });
        navigate('/home');
      }, 2000); // Sau khi đổi mật khẩu thành công, thực hiện logout và điều hướng đến trang login
    } catch (err) {
      setError(err.response?.data?.message || 'Lỗi không xác định');
    }
  };


  return (
    <div className="d-flex min-vh-100">
      <Sidebar />
      <div className="flex-grow-1 p-4">
        <div className="d-flex justify-content-between align-items-center mb-4">
          <strong>Đổi mật khẩu</strong>
        </div>

        <form onSubmit={handleSubmit} style={{ maxWidth: '500px' }}>
          {message && <div className="alert alert-success">{message}</div>}
          {error && <div className="alert alert-danger">{error}</div>}

          <div className="mb-3">
            <label className="form-label">Mật khẩu hiện tại</label>
            <input
              type="password"
              className="form-control"
              name="current_password"
              value={form.current_password}
              onChange={handleChange}
              required
            />
          </div>

          <div className="mb-3">
            <label className="form-label">Mật khẩu mới</label>
            <input
              type="password"
              className="form-control"
              name="new_password"
              value={form.new_password}
              onChange={handleChange}
              required
            />
          </div>

          <div className="mb-3">
            <label className="form-label">Xác nhận mật khẩu mới</label>
            <input
              type="password"
              className="form-control"
              name="new_password_confirmation"
              value={form.new_password_confirmation}
              onChange={handleChange}
              required
            />
          </div>

          <button type="submit" className="btn btn-primary">Xác nhận</button>
        </form>
      </div>
    </div>
  );
}

export default ChangePassword;
