import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { Link } from '@inertiajs/react';
import React from 'react';

import { HeaderUser } from './HeaderUser';

export const Breadcrumb = ({ icon, items, current }) => {
    return (
        <div className="mb-6 flex flex-col sm:flex-row gap-3 items-center justify-between relative">
            <h2 className="text-2xl font-bold text-black">
                <FontAwesomeIcon icon={icon} className="mr-2" /> {current}
            </h2>

            <div className="flex items-center gap-3">
                <nav className="ml-auto">
                    <ol className="flex items-center gap-1.5">
                        {items.map((item, index) => (
                            <li key={index}>
                                <Link
                                    className="font-medium text-slate-500"
                                    href={item.params ? route(item.link, item.params) : route(item.link)}
                                >
                                    {item.label} /
                                </Link>
                            </li>
                        ))}
                        <li className="font-medium text-black">{current}</li>
                    </ol>
                </nav>

                <HeaderUser />
            </div>
        </div>
    );
};
