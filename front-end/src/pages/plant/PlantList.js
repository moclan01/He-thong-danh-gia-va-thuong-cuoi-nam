import React, { useEffect, useState } from 'react';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import PlantForm from './PlantForm';
import { getPlants, deletePlant } from '../../services/plantService';
import Button from '../../components/Button';
import Modal from '../../components/Modal';

const PlantList = () => {
  const [plants, setPlants] = useState([]);
  const [loading, setLoading] = useState(true);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [selectedPlant, setSelectedPlant] = useState(null);

  const fetchPlants = async () => {
    try {
      const data = await getPlants();
      setPlants(data);
    } catch (error) {
      toast.error('Error fetching plants!');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchPlants();
  }, []);

  const handleDelete = async (id) => {
    if (window.confirm('Are you sure you want to delete this plant?')) {
      try {
        await deletePlant(id);
        setPlants(plants.filter((plant) => plant.plant_id !== id));
        toast.success('Plant deleted successfully!');
      } catch (error) {
        toast.error('Error deleting plant!');
      }
    }
  };

  const openModal = (plant = null) => {
    setSelectedPlant(plant);
    setIsModalOpen(true);
  };

  const closeModal = () => {
    setSelectedPlant(null);
    setIsModalOpen(false);
  };

  const handleSuccess = () => {
    fetchPlants();
    closeModal();
  };

  if (loading) {
    return React.createElement(
      'div',
      { className: 'text-center mt-5' },
      'Loading...'
    );
  }

  return React.createElement(
    'div',
    { className: 'container mt-4' },
    React.createElement('h1', { className: 'mb-4' }, 'Plant Management'),
    React.createElement(Button, {
      className: 'btn btn-primary mb-4',
      onClick: () => openModal(),
    }, 'Add New Plant'),
    React.createElement(
      'table',
      { className: 'table table-bordered table-hover' },
      React.createElement(
        'thead',
        { className: 'table-light' },
        React.createElement(
          'tr',
          null,
          React.createElement('th', null, 'ID'),
          React.createElement('th', null, 'Plant Name'),
          React.createElement('th', null, 'Actions')
        )
      ),
      React.createElement(
        'tbody',
        null,
        plants.map((plant) =>
          React.createElement(
            'tr',
            { key: plant.plant_id },
            React.createElement('td', null, plant.plant_id),
            React.createElement('td', null, plant.plant_name),
            React.createElement(
              'td',
              null,
              React.createElement(Button, {
                className: 'btn btn-warning btn-sm me-2',
                onClick: () => openModal(plant),
              }, 'Edit'),
              React.createElement(Button, {
                className: 'btn btn-danger btn-sm',
                onClick: () => handleDelete(plant.plant_id),
              }, 'Delete')
            )
          )
        )
      )
    ),
    React.createElement(Modal, {
      isOpen: isModalOpen,
      onClose: closeModal,
      title: selectedPlant ? 'Edit Plant' : 'Add Plant',
    }, React.createElement(PlantForm, { plant: selectedPlant, onSuccess: handleSuccess })),
    React.createElement(ToastContainer, null)
  );
};

export default PlantList;