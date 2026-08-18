import { Head, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';

import { NotificationMessage } from '@/Components/Manager/NotificationMessage';

const AdminLayout = ({ children }) => {
    const { message } = usePage().props;

    const [notifications, setNotifications] = useState([]);

    useEffect(() => {
        if (message) {
            const newNotification = { id: Date.now(), ...message };
            setNotifications((prevNotifications) => [...prevNotifications, newNotification]);

            const timer = setTimeout(() => {
                setNotifications((prevNotifications) => prevNotifications.filter((notification) => notification.id !== newNotification.id));
            }, 5300);

            return () => clearTimeout(timer);
        }
    }, [message]);

    return (
        <>
            <Head>
                <title>Links | Manager</title>
                <link rel="icon" href={`/favicon.ico`} type="image/x-icon" />
            </Head>

            <main className="flex bg-slate-50">
                <div className="mx-auto py-3 w-full min-h-screen">
                    <div className="mx-auto max-w-screen-2xl p-4 max-md:mt-16 -mb-4 md:p-6 2xl:p-10">{children}</div>
                </div>
            </main>

            {notifications.map((notification) => (
                <NotificationMessage
                    key={notification.id}
                    type={notification.type}
                    message={notification.msg}
                    show={true}
                    onClose={() => setNotifications((prevNotifications) => prevNotifications.filter((n) => n.id !== notification.id))}
                />
            ))}
        </>
    );
};

export default AdminLayout;
