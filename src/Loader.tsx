import React from 'react';
import App from '@hubleto/react-ui/core/App'
import Translator from '@hubleto/react-ui/core/Translator';
import FormCustomizer from '@hubleto/react-ui/core/FormCustomizer';
import { type FormMeta } from '@hubleto/react-ui/components/fc/FormInterfaces';
import TableEvents from './Components/FC/TableEvents'
import TableEventHasUsers from './Components/FC/TableEventHasUsers'

const parentApp = 'Hubleto/App/External/WaiBlue/OhsEvents';
const T = new Translator(parentApp + '/Loader', 'Loader');

// "Plánovanie vozidiel" tab in the car form (OhsCore); a new booking is named after the car (legacy).
function mountCarBookingsTab() {
  return {
    title: T.translate('Car bookings'),
    content: (form: FormMeta) => {
      if (form.id <= 0) return <div className='alert alert-info'>{T.translate('Save the car first.')}</div>;
      const carName = String(form.originalRecord?.name ?? '');
      return <TableEvents
        uid={form.uid + '_table_car_bookings'}
        parentForm={form}
        idCar={form.id}
        formDefaultValues={{id_car: form.id, name: carName}}
      />;
    },
  };
}

class OhsEventsApp extends App {
  init() {
    super.init();
    globalThis.hubleto.registerReactComponent('OhsEventsTableEvents', TableEvents);
    globalThis.hubleto.registerReactComponent('OhsEventsTableEventHasUsers', TableEventHasUsers);
    FormCustomizer.addTab('FormCar', 'ohs-car-bookings', mountCarBookingsTab);
  }
}

globalThis.hubleto.registerApp(parentApp, new OhsEventsApp());
