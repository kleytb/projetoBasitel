import React, { useState } from 'react';
import { Nav, NavLink1, NavLink2, NavLink3, Bars, DropD, NavMenu, NavBtn, NavBtnLink, Ft } from './Navel';
import Logo from './../../template/logobasitel.jpg'
import './Nav.css'


const Navbar = ({part1, part2 }) => {

    function scrollTo(ref) {
        
        window.scrollTo({
            top: ref.current.offsetTop,
            behavior: 'smooth',
        })
    }

    return (
        <>
           <Nav>
                <div className='lft'>
                    <Ft to ="/">
                        <img  src={Logo} />
                    </Ft>
                </div>


                <div className='rght'>
                         <Bars />
                        <DropD>
                        <ul>
                            <li><a href='#'>Funcionalidades</a></li>
                            <li><a href='#'>Sobre nós</a></li>
                            <li><a href='#'>Log in</a></li>
                        </ul>   
                        </DropD>  
                        <NavLink1 to="/" onClick={() => scrollTo(part1)}  activeStyle>
                           Funcionalidades
                        </NavLink1>
                        <NavLink2 to="/ " onClick={() => scrollTo(part2)}  activeStyle>
                          Sobre nós
                        </NavLink2>
                        <NavLink3 to="/signin"  activeStyle>
                          Log in
                        </NavLink3>
                        <NavBtnLink to="/register">Criar conta</NavBtnLink> 
               </div>
               {/* <NavBtn>
                   <NavBtnLink to="/create">Criar conta</NavBtnLink> 
               </NavBtn> */}
           </Nav>
        </>
    )
}

export default Navbar;
