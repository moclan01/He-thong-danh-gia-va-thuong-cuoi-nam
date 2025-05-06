import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { ToastContainer, toast } from 'react-toastify';
import Button from '../components/Button';
import { login } from '../services/authService';


const Login = () => {
    const [credentials, setCredentials] = useState({ username: '', password: '' });
    const navigate = useNavigate();
  
    const handleChange = (e) => {
      setCredentials({ ...credentials, [e.target.name]: e.target.value });
    };
  
    const handleSubmit = async (e) => {
      e.preventDefault();
      try {
        await login(credentials);
        toast.success('Login successful!');
        navigate('/');
      } catch (error) {
        toast.error(error.message || 'Login failed!');
      }
    };
  
    return React.createElement(
      'div',
      { className: 'container mt-5' },
      React.createElement(
        'div',
        { className: 'row justify-content-center' },
        React.createElement(
          'div',
          { className: 'col-md-4' },
          React.createElement(
            'div',
            { className: 'card p-4' },
            React.createElement('h2', { className: 'text-center mb-4' }, 'Login'),
            React.createElement(
              'form',
              { onSubmit: handleSubmit },
              React.createElement(
                'div',
                { className: 'mb-3' },
                React.createElement(
                  'label',
                  { htmlFor: 'username', className: 'form-label' },
                  'Username'
                ),
                React.createElement('input', {
                  type: 'text',
                  name: 'username',
                  id: 'username',
                  value: credentials.username,
                  onChange: handleChange,
                  className: 'form-control',
                  required: true,
                })
              ),
              React.createElement(
                'div',
                { className: 'mb-3' },
                React.createElement(
                  'label',
                  { htmlFor: 'password', className: 'form-label' },
                  'Password'
                ),
                React.createElement('input', {
                  type: 'password',
                  name: 'password',
                  id: 'password',
                  value: credentials.password,
                  onChange: handleChange,
                  className: 'form-control',
                  required: true,
                })
              ),
              React.createElement(
                'div',
                { className: 'd-grid' },
                React.createElement(Button, {
                  type: 'submit',
                  className: 'btn btn-primary',
                }, 'Login')
              )
            )
          )
        )
      ),
      React.createElement(ToastContainer)
    );
  };
  
  export default Login;