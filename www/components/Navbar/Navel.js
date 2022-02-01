import styled from 'styled-components';
import { NavLink as Link } from 'react-router-dom';
import { FaBars } from 'react-icons/fa'

export const Nav = styled.nav`
width: 110vw;
background: #212121;
height: 2.5rem;
display: flex;
justify-content: space-between;
/* padding: 0.5rem calc((100vw - 1000px) / 2); */
padding: 1rem 4rem;
z-index: 10;
width: 97.8%; 

.lft{
    width: 20%;
    display: flex; 
    align-items: center;
    
}

.rght{
    display: flex; 
    width: 55%;
    justify-content: flex-end;
    margin-right: 3%; 
    flex-direction: row;
    gap: 2rem;
    color: white;
    align-items: center;

    span{
        padding: 1rem;
        font-size: 1.2rem;
        color: blue;
    };   
}

`
export const Ft = styled(Link)`

 color: #fff;
 text-decoration: none;
 padding: 0 1.9rem;
 height: 50%;
 cursor: pointer;
 font-size: 1.05rem;
 width: 5rem; 
 font-family: 'Roboto', cursive;

/* margin-left: -20rem; */



 &.active {     
     color: #78bdc2;
 }
 `

 export const NavLink1 = styled(Link)`

 color: #fff;
 text-decoration: none;
padding: 0 2.5rem; 
 height: 50%;
 cursor: pointer;
 font-size: 1.05rem;

 font-family: 'Roboto', cursive;
 justify-content: center;

/* margin-left: -20rem; */



 &.active {     
     color: #78bdc2;
 }
@media screen and (max-width: 903px) {
        
            display: none;
        
        
    }

 `
 export const NavLink2 = styled(Link)`

 color: #fff;
 text-decoration: none;
 padding:  2.5rem;
 height: 50%;
 cursor: pointer;
 font-size: 1.05rem;
; 
 font-family: 'Roboto', cursive;
 justify-content: center;

/* margin-left: -20rem; */



 &.active {     
     color: #78bdc2;
 }

 @media screen and (max-width: 903px) {
        
        display: none;
    
    
}
 `
 export const NavLink3 = styled(Link)`


 color: #fff;
 text-decoration: none;
 padding: 1rem;
 height: 50%;
 cursor: pointer;
 font-size: 1.05rem;
   
 font-family: 'Roboto', cursive;


/* margin-left: -20rem; */



 &.active {     
     color: #78bdc2;
 }

 @media screen and (max-width: 903px) {
        
            display: none;
        
        
    }
 
`

export const Bars = styled(FaBars)`
    
    display: none;
    color: #fff;


    @media screen and (max-width: 903px) {
        display: block;
        position: absolute;
        top: -0.5%; 
        right: 0;
        transform: translate(-100%, 75%);
        font-size: 2rem;
        cursor: pointer;
        justify-content: center;
        alignItems: center
    }
`
export const DropD = styled.div`
     position: absolute;
     display: none;
     margin-top:8%;
     margin-left: -6.5%;
     background-color: #333;
     z-index: 9999999;     
     justify-content: center;
     
    ul li{
        margin-top: 13%; 
        margin-left: -28%;
        list-style: none;
        }

    a{
        color: #fff;
        text-decoration: none;  
    }

  
    

    @media screen and (max-width: 903px) {
        display: block;
        position: absolute;
        top: 0%; 
        left: 90%;   
        font-size: 1rem;
        
    }
`

export const NavMenu = styled.div`

    display: flex;
    align-items: center; 
    width: 100%;
    /* margin-right: -22%;  */
   
    /* margin-right: 24px; */

    @media screen and (max-width: 903px) {
        display: none;
    }
`

export const NavBtn = styled.nav`
    display: flex;
    align-items: center;
    /* margin-right: 24px; */
    

    @media screen and (max-width: 903px) {
        display: none;
    }
`

export const NavBtnLink = styled(Link)`
    border-radius: 6px;
    background: tranparent;
    padding: 10px 22px;
    color: #fff;
    border: solid;
    outline: none;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    text-decoration: none;
    height: 2vh;
    line-height: 2vh;


    &.hover {
        transition: all 0.2s ease-in-out;
        background: #fff;
        color: #010606;

    }

    @media screen and (max-width: 903px) {
        display: none;
    }
`
