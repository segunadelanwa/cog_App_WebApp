import React  from 'react';
import './Modal.css'; 
import Backdrop from '../Backdrop/Backdrop';


const Modal = (props) => (
    props.show ?  
     
    <div >
    <Backdrop  show={props.show}  clicked={props.clicked} />
        <div className="Modal"  
        
                     style={{
                     transform: props.show ? 'translateY(0)' : 'translateY(-100vh)',
                     opacity: props.show ? '1' : '0'
                     }}
                >
     
      

        {props.children}
        </div>
    </div> 
    : null
);

 
export default Modal;
 //show={this.props.show} clicked={this.props.modalClosed}
//  <div>
//   <Backdrop  show={this.props.show}  clicked={this.props.clicked} />
//      <div
//          className={classes.Modal}
//              style={{
//              transform: this.props.show ? 'translateY(0)' : 'translateY(-100vh)',
//              opacity: this.props.show ? '1' : '0'
//              }}>
//          {this.props.children}
//      </div>
//  </div>