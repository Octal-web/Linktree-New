import { faAngleDown, faAngleUp, faSignOut, faUserCircle } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { useEffect, useRef, useState } from 'react';

import { ConfirmModal } from './ConfirmModal';

export const HeaderUser = () => {
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [isMenuOpen, setIsMenuOpen] = useState(false);

    const menuRef = useRef(null);

    const openModal = () => {
        setIsModalOpen(true);
    };

    const closeModal = () => {
        setIsModalOpen(false);
    };

    useEffect(() => {
        const handleClickOutside = (event) => {
            if (menuRef.current && !menuRef.current.contains(event.target)) {
                setIsMenuOpen(false);
            }
        };

        document.addEventListener('mousedown', handleClickOutside);

        return () => {
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, []);

    return (
        <>
            <div ref={menuRef}>
                <button onClick={() => setIsMenuOpen((prev) => !prev)} className="flex items-center gap-2 ml-5 hover:cursor-pointer">
                    <FontAwesomeIcon className="size-9" icon={faUserCircle} />

                    <FontAwesomeIcon className="size-4" icon={isMenuOpen ? faAngleUp : faAngleDown} />
                </button>

                {isMenuOpen && (
                    <div className="absolute right-0 sm:top-10 bg-white rounded shadow-md py-2 w-36 z-10">
                        <button onClick={openModal} className="w-full text-left px-4 py-2 hover:bg-gray-100">
                            <FontAwesomeIcon className="size-4 mr-2" icon={faSignOut} />
                            Sair
                        </button>
                    </div>
                )}
            </div>

            {isModalOpen && (
                <ConfirmModal closeModal={closeModal} icon={faSignOut} type="logOut" confirm={route('Manager.Usuarios.logout')} />
            )}
        </>
    );
};
