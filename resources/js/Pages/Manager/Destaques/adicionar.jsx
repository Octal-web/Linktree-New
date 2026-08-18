import { faImage } from '@fortawesome/free-solid-svg-icons';
import { useForm } from '@inertiajs/react';
import { useEffect } from 'react';

import { Breadcrumb } from '@/Components/Manager/Breadcrumb';
import { ButtonGroup } from '@/Components/Manager/ButtonGroup';
import { FormGroup } from '@/Components/Manager/Inputs/FormGroup';
import AdminLayout from '@/Layouts/AdminLayout';

const Page = () => {
    const { data, setData, post, errors } = useForm();

    const breadcrumbItems = [
        { label: 'Home', link: 'Manager.Home.index' },
        { label: 'Destaques', link: 'Manager.Home.index' },
    ];

    const selectOptions = [
        { value: 'imagem_texto_sobreposto', label: 'Texto sobreposto na imagem' },
        { value: 'bloco_e_imagem', label: 'Bloco e texto' },
        { value: 'imagem_e_bloco', label: 'Texto e bloco' },
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
                max: 220,
            },
        ],
        [
            {
                titulo: 'Formato',
                name: 'formato',
                tamanho: 'col-span-12 lg:col-span-6',
                tipo: 'select',
                options: selectOptions,
            },
            {
                titulo: 'Cor de fundo',
                name: 'cor_bg',
                tamanho: 'col-span-6 lg:col-span-1',
                tipo: 'cor',
                max: 20,
            },

            {
                titulo: 'Cor do texto',
                name: 'cor_texto',
                tamanho: 'col-span-6 lg:col-span-1',
                tipo: 'cor',
                max: 20,
            },
        ],
        [
            {
                titulo: 'Texto',
                name: 'conteudo',
                tamanho: 'col-span-12 lg:col-span-8',
                tipo: 'texto_longo',
                editor: true,
                max: 300,
                toolbar: ['Heading', 'Bold', 'Italic', 'Underline', 'Image'],
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

    const initializeData = (inputItems) => {
        let initialData = {};
        inputItems.forEach((group) => {
            group.forEach((item) => {
                initialData[item.name] = item.tipo === 'check' ? false : '';
            });
        });
        return initialData;
    };

    useEffect(() => {
        const initialData = initializeData(inputItems);
        setData(initialData);
    }, []);

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('Manager.Destaques.novo'), {
            preserveScroll: true,
        });
    };

    const onChange = (name, value) => {
        setData(name, value);
    };

    const handleImageCrop = (croppedImage, fileExtenstion, name) => {
        setData((prevData) => ({
            ...prevData,
            [name]: croppedImage,
        }));
    };

    return (
        <AdminLayout>
            <Breadcrumb icon={faImage} items={breadcrumbItems} current="Adicionar" />

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
