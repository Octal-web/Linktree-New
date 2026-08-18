import { faArrowLeft, faSave } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { Link } from '@inertiajs/react';

export const ButtonGroup = ({ href }) => {
    return (
        <div className="flex items-center justify-end">
            <Link
                href={route(href)}
                className="flex items-center w-fit rounded-lg border border-red-700 text-red-700 px-3 py-2 mr-3 cursor-pointer transition-all hover:bg-red-100"
            >
                <FontAwesomeIcon icon={faArrowLeft} className="mr-2" />
                Voltar
            </Link>

            <button
                type="submit"
                className="block relative w-fit rounded-lg border border-gray-300 px-3 py-2 cursor-pointer transition-all hover:bg-slate-200"
            >
                <FontAwesomeIcon icon={faSave} className="text-slate-700 mr-2" />
                Salvar
            </button>
        </div>
    );
};
