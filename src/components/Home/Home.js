import React, { useState, useEffect } from "react";
import { BrowserRouter as  Router, Route, Routes} from "react-router-dom";  
import { AuthContext }  from '../context'; 
import Login            from '../Login/Login';   

function Home() { 
  const [show, setShow] = useState(null);
  const[userToken, setUserToken]   = useState('0');  
  
  

  const authContext = React.useMemo(() => ({
  
    
  
        signIn1 : () => {
        
          
            setUserToken('1'); 
            setShow(true); 


        },
      
        signIn2 : () => {
          
 
            setUserToken('1'); 
            setShow(false); 
            
          
        },
          
        signOut: () => {
      
      
       
          localStorage.removeItem('loginSession');
          localStorage.removeItem('adminSession');
          localStorage.removeItem('authLogin');
      
          setUserToken('0');
        
          setShow(null); 
      
              
        
      
        },
        
    
        
 
  
    } ));

  
 


 

  return (
    <AuthContext.Provider value={authContext}>
 <Router>
     
         
            {
             
             
                            <Routes>
                                                <Route path='/'              element={<Login   />} />    
                            </Routes>
              
               
            }
          
            
     </Router>
   
    </AuthContext.Provider>
  )
}

export default Home;