<template>
  <div class="pane fifth-step">
    <h1>Resumen</h1>
    <div v-if="carShop && carShop.nombre !== 'Taller para Arreglo Directo'">
      <p>Valida y confirma tu información y la del taller que seleccionaste</p>

      <div class="summary">
        <div class="icon"></div>
        <div class="body">
          <h3>{{ carShop.nombre }}</h3>

          <span class="label">Dirección</span>
          <div class="info">{{ carShop.direccion }} </div>

          <span class="label">Email</span>
          <div class="info">{{ carShop.email }} </div>

          <span class="label">Teléfono</span>
          <div class="info">{{ carShop.telefono }} </div>

          <!-- <span class="label">Horario de atención:</span>
          <div class="info">
            <p>Lunes a Sábado</p>
            <p>de 8:00 a.m. a 5:00 p.m.</p>
          </div> -->

          <div class="alert">
            <strong>Recomendamos realizar el ingreso de tu vehículo en los próximos 10 días,
              recuerda contactar al taller para coordinar el ingreso</strong>
          </div>
        </div>
      </div>
    </div>
    <div v-else-if="claimType === 'CLAIM_TYPE_PTH'">
      <p>Lo que debes saber si tu vehículo fue hurtado</p>
      <div class="summary">
        <div class="icon"></div>
        <div class="body">
          <ol>
            <li>
              <p>
                Radica el denuncio por hurto, junto con el certificado de No recuperación mediante nuestra
                página Web <a href="https://www.libertyseguros.co/">https://www.libertyseguros.co/</a>
                en las siguientes Opciones &#8594; <strong>¿Te paso Algo? &#8594; ¿Tienes una solicitud del siniestro de tu vehículo? &#8594; Crear solicitud &#8594;
                Siniestros vehículos.</strong>
              </p>
            </li>
            <li>
              <p>
                A tu correo electrónico se enviará la información necesaria para continuar
                con el estudio del caso.
              </p>
            </li>
            <li>
              <p>
                El analista de tu caso se comunicará para informarte en detalle el proceso
                de indemnización y el trámite que se debe realizar ante tránsito.
              </p>
            </li>
            <li>
              <p>
                El proceso solo dará inicio cuando la documentación este completa.
              </p>
            </li>
          </ol>
        </div>
      </div>
    </div>
    <div v-else>
      <p>Lo que debes saber para reparar el vehículo en tu taller de confianza</p>

      <div class="summary">
        <div class="icon"></div>
        <div class="body">
          <ol>
            <li class="list-item">
              <h3>Reúne los siguientes documentos:</h3>
              <ul>
                <li>
                  <p>
                    Copia de informe de tránsito o croquis (si lo tienes) o fallo o
                    resolución de tránsito o acuerdo conciliatorio o carta del asegurado
                    donde indique la versión de los hechos, fotografías que demuestren ocurrencia,
                    fecha, lugar, nombre del conductor y autorización para afectar su póliza.
                  </p>
                </li>
                <li>
                  <p>Fotografías claras de los daños del vehículo</p>
                </li>
                <li>
                  <p>Cotización de mano de obra y repuestos de tu taller de confianza</p>
                </li>
              </ul>
            </li>
            <li class="item-list">
              <p>
                Radica los documentos mediante nuestra página Web https://www.libertyseguros.co/ en las
                siguientes Opciones <strong>&#8594; ¿Te paso Algo? &#8594; ¿Tienes una solicitud del siniestro de tu vehículo? &#8594; Crear solicitud &#8594; Siniestros vehículos.</strong>
              </p>
            </li>
            <li class="list-item">
              <h3>Te informaremos por correo la respuesta del caso</h3>
            </li>
            <li class="list-item">
              <h3>Recibirás la notificación del pago *</h3>
              <p>
                <strong>
                  * 1. Recuerda que este servicio opera por reembolso, por tanto, los documentos
                  que nos hagas llegar estarán sujetos a estudio por parte de nuestros ingenieros.
                  2. Una vez se autorice la cotización enviada, procederemos con el pago de un anticipo del 60%.
                  3. Al finalizar el arreglo, deberás enviarnos los soportes de la reparación de tu vehículo para concluir el pago del 40% restante.
                </strong>
              </p>
            </li>
          </ol>
        </div>
      </div>
    </div>

    <div class="actions">
      <a  href="#" v-on:click.prevent="prevStep(4)">Volver</a>
      <button v-on:click="submit" type="button">Finalizar</button>
    </div>

  </div>
</template>
<script>
import steps from '../mixins/steps';

export default {
  mixins: [steps],
  props: ['carShop', 'claimType'],
  methods: {
    submit: function () {
       this.$emit('submit');
        QSI.API.unload();
        QSI.API.load().then(QSI.API.run());
    }
  }
}
</script>
