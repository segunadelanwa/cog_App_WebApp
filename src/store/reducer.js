

const initialState = {

    sub_amount: 500,
    sub_bene: 0,

}


const reducer = (state = initialState, action) =>{

    if(action.type === 'SUB_CAL') {
        
        return {
           
            sub_bene : state.sub_amount * action.value
        }

    }





    return state;
}


export default reducer;