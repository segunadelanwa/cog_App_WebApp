import React from 'react';
import { IoCloseCircleSharp } from 'react-icons/io5';
import './Backdrop.css';

const Backdrop = (props) => (
    props.show ?   
    <div className="Backdrop"  onClick={props.clicked}>
    <IoCloseCircleSharp    style={{color: 'white',fontSize: '30px',marginTop: '150px'}} />
    </div> 
    : 
    null
);

export default Backdrop;
// props.show ? <div className={classes.Backdrop} onClick={props.clicked}></div> : null