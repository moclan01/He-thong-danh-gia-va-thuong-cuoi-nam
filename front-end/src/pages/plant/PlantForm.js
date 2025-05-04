import React, { useState, useEffect } from 'react';
import { ToastContainer, toast } from 'react-toastify';
import { createPlant, updatePlant } from '../../services/plantService';
import Button from '../../components/Button';


const PlantForm = ({ plant, onSuccess }) => {
  const [formData, setFormData] = useState({ plant_name: '' });

  useEffect(() => {
    if (plant) {
      setFormData({ plant_name: plant.plant_name });
    }
  }, [plant]);

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      if (plant) {
        await updatePlant(plant.plant_id, formData);
        toast.success('Plant updated successfully!');
      } else {
        await createPlant(formData);
        toast.success('Plant created successfully!');
      }
      onSuccess();
    } catch (error) {
      toast.error('Error saving plant!');
    }
  };

  return React.createElement(
    'form',
    { onSubmit: handleSubmit },
    React.createElement(
      'div',
      { className: 'mb-3' },
      React.createElement(
        'label',
        { htmlFor: 'plant_name', className: 'form-label' },
        'Plant Name'
      ),
      React.createElement('input', {
        type: 'text',
        name: 'plant_name',
        id: 'plant_name',
        value: formData.plant_name,
        onChange: handleChange,
        className: 'form-control',
        required: true,
      })
    ),
    React.createElement(
      'div',
      { className: 'd-flex justify-content-end' },
      React.createElement(Button, {
        type: 'submit',
        className: 'btn btn-primary',
      }, plant ? 'Update' : 'Create')
    ),
    React.createElement(ToastContainer, null)
  );
};

export default PlantForm;