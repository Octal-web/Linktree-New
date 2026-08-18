import { faImage } from '@fortawesome/free-solid-svg-icons';
import { useForm, usePage } from '@inertiajs/react';

import { Breadcrumb } from '@/Components/Manager/Breadcrumb';
import { ButtonGroup } from '@/Components/Manager/ButtonGroup';
import { FormGroup } from '@/Components/Manager/Inputs/FormGroup';
import AdminLayout from '@/Layouts/AdminLayout';

const Page = () => {
    const { link } = usePage().props;

    const { data, setData, post, errors } = useForm(link);

    const breadcrumbItems = [
        { label: 'Home', link: 'Manager.Home.index' },
        { label: 'Links', link: 'Manager.Home.index' },
    ];

    const inputItems = [
        [
            {
                titulo: 'Título',
                name: 'titulo',
                tamanho: 'col-span-12 lg:col-span-8',
                tipo: 'texto',
                max: 50,
            },
        ],
        [
            {
                titulo: 'URL',
                name: 'link',
                tamanho: 'col-span-12 lg:col-span-8',
                tipo: 'link',
                max: 200,
            },
        ],
        [
            {
                titulo: 'Imagem',
                name: 'imagem',
                tamanho: 'col-span-12 md:col-span-6',
                tipo: 'imagem',
                crop: false,
                largura: 1000,
                altura: 1000,
            },
        ],
    ];

    const handleSubmit = (e) => {
        e.preventDefault();

        post(route('Manager.Links.atualizar', { id: link.id }), {
            preserveScroll: true,
        });
    };

    const onChange = (name, value) => {
        setData((prevData) => ({
            ...prevData,
            [name]: value,
        }));
    };

    const handleImageCrop = (croppedImage, fileExtenstion, name) => {
        setData((prevData) => ({
            ...prevData,
            [name]: croppedImage,
        }));
    };

    return (
        <AdminLayout>
            <Breadcrumb icon={faImage} items={breadcrumbItems} current="Editar" />

            <div className="mb-6 rounded-sm border border-stroke bg-white px-5 py-5 shadow-md">
                <div className="mt-10">
                    <form onSubmit={handleSubmit}>
                        {inputItems.map((group, groupIndex) => (
                            <div key={groupIndex} className="grid grid-cols-12 gap-x-6">
                                {group.map((input, index) => (
                                    <div key={index} className={`w-full ${input.tamanho}`}>
                                        <FormGroup
                                            input={input}
                                            value={data[input.name]}
                                            onChange={onChange}
                                            handleImageCrop={handleImageCrop}
                                        />
                                        {errors[input.name] && <p className="text-sm text-red-500 -mt-5 mb-3">{errors[input.name]}</p>}
                                    </div>
                                ))}
                            </div>
                        ))}

                        <ButtonGroup href="Manager.Home.index" />
                    </form>
                </div>
            </div>
        </AdminLayout>
    );
};

export default Page;
