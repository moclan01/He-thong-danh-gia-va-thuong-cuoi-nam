import React from 'react';

const Modal = ({ isOpen, onClose, title, children }) => {
  if (!isOpen) return null;

  return React.createElement(
    'div',
    { className: 'modal fade show d-block', style: { backgroundColor: 'rgba(0,0,0,0.5)' } },
    React.createElement(
      'div',
      { className: 'modal-dialog modal-dialog-centered' },
      React.createElement(
        'div',
        { className: 'modal-content' },
        React.createElement(
          'div',
          { className: 'modal-header' },
          React.createElement('h5', { className: 'modal-title' }, title),
          React.createElement('button', {
            type: 'button',
            className: 'btn-close',
            onClick: onClose,
          })
        ),
        React.createElement('div', { className: 'modal-body' }, children)
      )
    )
  );
};

export default Modal;