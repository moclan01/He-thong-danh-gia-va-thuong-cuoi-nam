import React from 'react';

const Button = ({ children, onClick, className, ...props }) => {
  return React.createElement(
    'button',
    {
      className: `btn ${className}`,
      onClick: onClick,
      ...props,
    },
    children
  );
};

export default Button;