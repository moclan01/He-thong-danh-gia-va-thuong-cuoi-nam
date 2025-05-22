import React, { useEffect, useState } from 'react';

import { useNavigate } from 'react-router-dom';
import MainLayout from '../../MainLayout';
import axiosInstance from '../../../services/axiosInstance';

function PlantManager() {
    const [plants, setPlants] = useState([]);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const navigate = useNavigate();

  useEffect(() => {
    fetchPlants();
  }, []);

  const fetchPlants = async () => {
    try {
      const response = await axiosInstance.get('/plants');
      setPlants(response.data);
      setError('');
    } catch (err) {
      setError('Không thể tải danh sách nhà máy.');
      console.error(err);
    }
  };

  const handleDelete = async (id) => {
    if (window.confirm('Bạn có chắc muốn xóa nhà máy này không?')) {
      try {
        await axiosInstance.delete(`/plants/${id}`);
        setPlants(plants.filter((item) => item.plant_id !== id));
        setSuccess('Xóa nhà máy thành công.');
        setError('');
      } catch (err) {
        setError(err.response?.data?.message || 'Không thể xóa nhà máy.');
      }
    }
  };

  return (
    <MainLayout>
      <h2>Danh sách nhà máy</h2>
      {error && <div className="alert alert-danger">{error}</div>}
      {success && <div className="alert alert-success">{success}</div>}

      <button
        className="btn btn-primary mb-3"
        onClick={() => navigate('/plant/add')}
      >
        Thêm nhà máy mới
      </button>

      <table className="table table-bordered">
        <thead>
          <tr>
            <th>Tên nhà máy</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          {plants.length > 0 ? (
            plants.map((plant) => (
              <tr key={plant.plant_id}>
                <td>{plant.plant_name}</td>
                <td>
                  <button
                    className="btn btn-warning btn-sm me-2"
                    onClick={() => navigate(`/plant/update/${plant.plant_id}`)}
                  >
                    Sửa
                  </button>
                  <button
                    className="btn btn-danger btn-sm"
                    onClick={() => handleDelete(plant.plant_id)}
                  >
                    Xóa
                  </button>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="2" className="text-center">Không có nhà máy nào.</td>
            </tr>
          )}
        </tbody>
      </table>
    </MainLayout>
  );
}

export default PlantManager