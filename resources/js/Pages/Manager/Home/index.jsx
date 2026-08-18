import { faHome } from '@fortawesome/free-solid-svg-icons';
import { usePage } from '@inertiajs/react';

import { BlockContent } from '@/Components/Manager/BlockContent';
import { Breadcrumb } from '@/Components/Manager/Breadcrumb';
import AdminLayout from '@/Layouts/AdminLayout';

const Page = () => {
    const { links, destaques } = usePage().props;

    const contentLinks = {
        nome: ['Links', 'link'],
        controller: 'Links',
        imagens: true,
        imgClass: 'object-scale-down h-40',
        editavel: true,
        conteudos: links,
    };

    const contentDestaques = {
        nome: ['Destaques', 'destaque'],
        controller: 'Destaques',
        imagens: true,
        imgClass: 'object-scale-down h-40',
        editavel: true,
        conteudos: destaques,
    };

    const breadcrumbItems = [];

    return (
        <AdminLayout>
            <Breadcrumb icon={faHome} items={breadcrumbItems} current="Home" />

            <BlockContent content={contentLinks} />

            <BlockContent content={contentDestaques} />
        </AdminLayout>
    );
};

export default Page;
