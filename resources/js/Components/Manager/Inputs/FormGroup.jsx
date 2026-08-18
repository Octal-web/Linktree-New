import { InputColor } from './InputColor';
import { InputFileImage } from './InputFileImage';
import { InputLink } from './InputLink';
import { InputSelect } from './InputSelect';
import { InputText } from './InputText';
import { InputTextArea } from './InputTextArea';
import { InputTipTapEditor } from './InputTipTapEditor';

export const FormGroup = ({ input, value, onChange, handleImageCrop }) => {
    switch (input.tipo) {
        case 'texto':
            return <InputText title={input.titulo} name={input.name} max={input.max} value={value} onChange={onChange} />;
        case 'texto_longo':
            return input.editor ? (
                <InputTipTapEditor
                    title={input.titulo}
                    name={input.name}
                    value={value}
                    max={input.max}
                    toolbar={input.toolbar}
                    onChange={onChange}
                />
            ) : (
                <InputTextArea title={input.titulo} name={input.name} value={value} max={input.max} onChange={onChange} />
            );
        case 'select':
            return (
                <InputSelect
                    title={input.titulo}
                    name={input.name}
                    value={value}
                    options={input.options}
                    onChange={onChange}
                    isMulti={input.isMulti}
                />
            );
        case 'cor':
            return <InputColor title={input.titulo} name={input.name} value={value} onChange={onChange} />;
        case 'imagem':
            return (
                <InputFileImage
                    title={input.titulo}
                    name={input.name}
                    imagem={input.imagem || value || '/admin/images/select.png'}
                    size={{ largura: input.largura, altura: input.altura }}
                    allowCrop={input.crop ? true : false}
                    onImageCrop={handleImageCrop}
                />
            );
        case 'link':
            return <InputLink title={input.titulo} name={input.name} value={value} max={input.max} onChange={onChange} />;
        default:
            return null;
    }
};
