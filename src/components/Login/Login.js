
import React, { useState, useEffect,useLayOutEffect } from "react";
import { Link, useNavigate,useLocation } from 'react-router-dom';
import axios from "axios"; 
import 'bootstrap/dist/css/bootstrap.min.css';  
import  './Login.css'; 
import Modal from "../UI/Modal/Modal";  
import { SubscriberPayment,Naira ,publicKey,publicKeyFlutter} from '../../BaseUrl';
import { usePaystackPayment } from 'react-paystack';
import { AuthContext }  from '../context'; 
import { connect } from 'react-redux';
import { FlutterWaveButton, closePaymentModal } from 'flutterwave-react-v3';


function Login( props ) { 
  const [fullname, setFullname] = useState('');
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');
  const [month, setMonth] = useState(''); 
  const [bene, setBene] = useState('0'); 
  const [amount, setAmount] = useState('0'); 
  const [message, setMessage] = useState('');
  const [show, setShow] = useState(false);
  const { signIn1 } = React.useContext(AuthContext);
  const[data, setData] = useState({
    amount: '', 
    email: '', 
    phone_number: '', 
    fullname: '', 
   
  })
   



const subFullname = (event) => {
  setFullname(event.target.value);
  setData({...data, fullname:event.target.value})
}

const subPhone = (event) => {
 setData({...data, phone_number:event.target.value})
  setPhone(event.target.value);
}


const subMonth = (event) => {
  //  onChange={e=> setPhone(e.target.value)}
  setMonth(event.target.value);
  
  let amtVal = '0';
  let beneVal = '0';

 

  if(event.target.value == 0){

     amtVal =   event.target.value * 0;
     beneVal =  0;
  
  }else if(event.target.value == 1){
      amtVal =   event.target.value * 500;
       beneVal =  0;
 
  
  }else if(event.target.value == 2){
       amtVal =   event.target.value * 470;
       beneVal =  1;
 
  
  }else if(event.target.value == 3){
      amtVal =   event.target.value * 450;
       beneVal =  2;

  }else if(event.target.value == 4){
      amtVal =   event.target.value * 430;
      beneVal =  2;

}else if(event.target.value == 5){
     amtVal =   event.target.value * 400;
     beneVal =  3;
   
}else if(event.target.value == 6){

     amtVal =   event.target.value * 400;
     beneVal =  4;

}



  


setData({...data, amount:amtVal})
  setAmount(amtVal);
  setBene(beneVal);
}
const search = useLocation().search;

useEffect(() => 
{     

  const email_m       = new URLSearchParams(search).get('email');
  const expry_date    = new URLSearchParams(search).get('expry_date');
  const full_name     = new URLSearchParams(search).get('fullname');
  const phone_no      = new URLSearchParams(search).get('phone');

  setEmail(email_m);
  setFullname(full_name);
  setPhone(phone_no);



},[]);


 
 
const config = {
   
  reference: (new Date()).getTime().toString(),
  email: email,
  amount: amount*100,

  publicKey: publicKey,
};

// PAYSTACK INTIGRATION
const onSuccess = (reference) => {
 

  setShow(true);
 

  const data = {   
    fullname: fullname, 
    phone: phone,
    month: month,
    amount: amount,
    email: email,
    bene: bene,
    reference: reference.reference

  };


  
    var headers = {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
    }

    fetch(SubscriberPayment,
    {
    method:'POST',
    header:headers,
    body: JSON.stringify(data)
    })
    .then((response) => response.json())
    .then((response) => {
     

      if(response[0].success == 'ok'){
        

        setMessage(response[0].feedback);
        setFullname('');
        setPhone('');
        setMonth(''); 
        setBene('0'); 
        setAmount('0'); 
        setEmail(''); 

      }else{

        setMessage(response[0].feedback);
      }
    


   
  
  })
  .catch(error => {
    setMessage('Oops! network error, please check your data and try again');
  });

 
 


};
 


const onClose = () => {
  setShow(true); 
setMessage('Payment Transaction Cancelled');
}

  const NumberFomat = (val) =>{

    if( val > 0){
          var value =  val* 1; 
          var result =  value.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return  Naira+result;  
    }else{

            return  Naira+0.00;  
    }
                                                     
     
    
}
  const showHandler =()=>{

    setShow(false);
    setMessage('')
 }

const PaystackHookExample = () => {

 
   const initializePayment = usePaystackPayment(config);
 

          if(fullname == '' || phone == '' || month == ''  )
          {

          setMessage('All form fields are required');

        }
        else
        {
            return (
                    
              <div  onClick={() => { initializePayment(onSuccess, onClose) }}  > 
              Subscribe
              </div>

            );

        }

 
 
    
};
///////////////////////////////////////

//// FLUTTERWAVE INTIGRATION
//FLWPUBK_TEST-d0ade1caf8210c54763d1555417a7df4-X
//FLWPUBK-a9d46aad1b57e34849a9faaf75c909f0-X

// "card_number":"5531886652142950",
// "cvv":"564",
// "expiry_month":"09",
// "expiry_year":"32",
//https://api.ravepay.co/flwv3-pug/getpaidx/api/verify/pwbt
//https://www.codewigs.com/blog/how-to-integrate-flutterwave-v3-payment-gateway-in-php-2020-12-29


const config2 = {
  public_key: publicKeyFlutter,
  tx_ref: Date.now(),
  amount: amount,
  currency: 'NGN',
  payment_options: 'transfer,card,mobilemoney,ussd',
  customer: {
    email: email,
     phone_number:phone,
    name: fullname,
  },
  customizations: {
    title: 'CITY OF GOD EBOOKS STORE ',
    description: 'CITY OF GOD EBOOKS SUBSCRIPTION',
    logo: 'https://cityofgoddevotions.com/all_photo/logo.png',
  },
};
 
 



//FLUTTER INTIGRATION
const webBookServerUpdate = () => {
 

  setShow(true);
 

  const data = {   
    fullname: fullname, 
    phone: phone,
    month: month,
    amount: amount,
    email: email,
    bene: bene,
    reference: config2.tx_ref

  };


  
    var headers = {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
    }

    fetch(SubscriberPayment,
    {
    method:'POST',
    header:headers,
    body: JSON.stringify(data)
    })
    .then((response) => response.json())
    .then((response) => {
     

      if(response[0].success == 'ok'){
        

        setMessage(response[0].feedback);
        setFullname('');
        setPhone('');
        setMonth(''); 
        setBene('0'); 
        setAmount('0'); 
        setEmail(''); 
        closePaymentModal();
      }else{

        setMessage(response[0].feedback);
      }
    


   
  
  })
  .catch(error => {
    setMessage('Oops! network error, please check your data and try again');
  });

 
 


};
 

 /*
Object {
   status: "completed", 
   customer: {…},
    transaction_id: 4628098,
     tx_ref: 1695975802774, 
     flw_ref: "MockFLWRef-1695976119104",
      currency: "NGN", 
      amount: 1350, 
      charged_amount: 1350, 
      charge_response_code: "00", 
      charge_response_message: "Approved Successful",
    
    }
​
amount: 1350
​
charge_response_code: "00"
​
charge_response_message: "Approved Successful"
​
charged_amount: 1350
​
created_at: "2023-09-29T08:28:38.000Z"
​
currency: "NGN"
​
customer: Object { name: "Adelanwa seun", email: "ziggyadex@gmail.com", phone_number: null }
​
flw_ref: "MockFLWRef-1695976119104"
​
redirectstatus: undefined
​
status: "completed"
​
transaction_id: 4628098
​
tx_ref: 1695975802774
 */
 const fwConfig = {
  
  
  ...config2,
  text: 'SUBSCRIBE',


      callback: (response) => {
            //  console.log(response)
            //  console.log(response.charge_response_message)

            if(response.charge_response_message == 'Approved Successful'){
              webBookServerUpdate();
            }else{
              closePaymentModal() 
              setMessage(response.status);
            }



    
      },
      onClose: () => {},

 

     
};

  const handleSubmit = e =>  {
  
  e.preventDefault();
  //setMessage('')
  //setShow(true);
  
      if(fullname == '' || phone == '' || month == ''  ){

        setMessage('All form fields are required');

      }
      else
      {



        
    }
}


 
    if(show){ 
      return (
        <div>
              {
              
                message == ''?
                  <center>
                    <Modal show={show}  >    
                    <img src="images/loading.gif"  style={{height: '100px'}}   /> 
                    <br  /> <small style={{color: '#0f202c'}}>Please Wait..</small>
                    </Modal> 
                  </center>
                  :

                 <center>
                  
                  <div>  
                  <Modal clicked={showHandler} show={show} > 
                 
                   {message}  
                   </Modal>
                  </div>  

                </center>
   
            
              }

      </div>

      )
    }
    else
    {

        return (
        <div className="App">
        <div className="App-header"> 
        <div className="Container1">  
        <img src="images/logo.png"   className="imgLogo"/> 
        <h1 className="TextHeader"> CITY OF GOD </h1><hr  className='homeHr'/>
        <p> EBOOKS SUBSCRIPTION  </p>

        <div >Sub Amount: <span style={{color:'#a8538b',fontWeight:'bolder',fontSize:25}}> {NumberFomat(amount)}</span>  </div>
        <hr  className='homeHr2'/>






      <form   onSubmit={handleSubmit}>  
  


        <div className='form-inputs'>
        <label htmlFor='create-email' className='form-label' style={{color:'#a8538b'}}>Subscriber Fullname</label>
        <input
        style={{backgroundColor:'#e9e9ed'}}
        id="text"
        type="text"
        name="Fullname"
        className="form-input" 
        onChange={subFullname}
        value={fullname}
        />

        </div>


          <div className='form-inputs'>
                    <label htmlFor='create-password' className='form-label' style={{color:'#a8538b'}}>Subscriber Phone</label>

                    <input 
                    style={{backgroundColor:'#e9e9ed'}}
                    type="text"
                    name="number"
                    className="form-input" 
                    onChange={subPhone}
                    value={phone}

                    />  
          </div>

          <div className='form-inputs'>
                    <label htmlFor='create-password' className='form-label' style={{color:'#a8538b'}}>Subscriber Email</label>

                    <input 
                    style={{backgroundColor:'#e9e9ed'}}
                    type="text"
                    name="number"
                    className="form-input" 
                    onChange={e=> setEmail(e.target.value)}
                    value={email}

                    />  
          </div>

        <div className='form-inputs' style={{display:'flex',flexDirection:'row', }}>

              <div className='form-inputs' style={{with:'45%'}}> 
                  <label htmlFor='create-password' className='form-label' style={{color:'#a8538b'}}>Sub Month </label>

                  <select id="amount" name="amount" className="form-input" onChange={subMonth}> 
                  <option value="0">Select Month </option>
                  <option value="1">1 Month </option>
                  <option value="2">2 Months </option>
                  <option value="3">3 Months </option>
                  <option value="4">4 Months </option>
                  <option value="5">5 Months </option>
                  <option value="6">6 Months </option>
                  </select>
              </div>

              <div className='form-inputs' style={{with:'45%',marginLeft:'5%'}}> 
                  <label htmlFor='create-password' className='form-label' style={{color:'#a8538b'}}>Sub Beneficaries </label>

                  <input
                  id="text"
                  type="text"
                  name="text"
                  style={{backgroundColor:'#e9e9ed'}}
                  className="form-input" 
                  value={bene}
                  readOnly/>  
              </div>

        </div>


{        
// <button type="submit"   className='form-input-btn'> 
//   <PaystackHookExample  />
// </button>
}


{        
// <button type="submit"   className='form-input-btn'> 
//   <FlutterWaveButton   {...fwConfig} />
// </button>
}

   
   <FlutterWaveButton type="submit" className='form-input-btn' {...fwConfig} />
 
 
        </form>



        </div>
        </div>

        
        </div>
        )


    }
    
  }


const mapStateToProps = state => {
 
  return {
    subAmt: state.sub_amount,
    subBene: state.sub_bene

  };

}

const mapDispatchToProps = (dispatch) => {

  return {
    
    subMonthCal : (month) => dispatch({type: 'SUB_CAL', value: month})

  };

};
export default connect(mapDispatchToProps,mapStateToProps)(Login);