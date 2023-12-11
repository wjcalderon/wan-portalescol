<?php

namespace Drupal\lib_core;

/**
 * Class Chat manager.
 */
class ChatManager implements ChatManagerInterface {

  /**
   * Construct method.
   */
  public function __construct() {
    // @todo . Inject dependencies.
  }

  /**
   * {@inheritdoc}
   */
  public function addChat($parameters) {
    $script = <<<EOT
    <script type='text/javascript'>
    var initESW = function (gslbBaseURL) {
        embedded_svc.settings.displayHelpButton = true; //O falso
        embedded_svc.settings.language = 'es'; //Por ejemplo, introduzca 'en' o 'en-US'
        embedded_svc.settings.defaultMinimizedText = "Chat";
        embedded_svc.settings.disabledMinimizedText = "Chat inactivo";
        embedded_svc.settings.loadingText = "Cargando";
        embedded_svc.settings.autoOpenPostChat = true;
        //embedded_svc.settings.storageDomain = 'yourdomain.com'; //(Establece el dominio para su desarrollo de modo que los visitantes puedan navegar por subdominios durante una sesión de chat)
        // Configuración para Chat
        embedded_svc.settings.directToButtonRouting = function (prechatFormData) {
            var servicestr = prechatFormData.find(item => item.name === "LGM_Servicio__c").value;
            if (servicestr === "Exámenes de diagnóstico simple")
                return "573K00000008SCc";
            else if (servicestr === "Exámenes especializados")
                return "573K00000008SCh";
            else if (servicestr === "Urgencias")
                return "573K00000008SCw";
            else if (servicestr === "Odontología")
                return "573K00000008SCr";
            else if (servicestr === "Medicamentos")
                return "573K00000008SCm";
            else if (servicestr === "Consulta externa")
                return "573K00000008R7u";
        };

        embedded_svc.settings.enabledFeatures = ['LiveAgent'];
        embedded_svc.settings.entryFeature = 'LiveAgent';
        embedded_svc.settings.extraPrechatFormDetails = [
            {
                "label": "Origin",
                "value": "Chat Salud Ecuador",
                "displayToAgent": true
            },
            {
                "label": "RecordTypeId",
                "value": "012K0000000Lv3rIAC",
                "transcriptFields": ["RecordTypeId"],
                "displayToAgent": true
            },
            {
                "label": "Nombre Completo",
                "transcriptFields": ["Nombre__c"],
                "displayToAgent": true
            },
            {
                "label": "Tipo identificación",
                "transcriptFields": ["LGM_TipIdentificacion__c"],
                "displayToAgent": true
            },
            {
                "label": "Número de identificación",
                "transcriptFields": ["Numero_de_identificacion__c"],
                "displayToAgent": true
            },
            {
                "label": "Servicio",
                "transcriptFields": ["Servicio__c"],
                "displayToAgent": true
            },
            {
                "label": "Pais",
                "value": "ECUADOR",
                "transcriptFields": ["LGM_Pais__c"],
                "displayToAgent": true
            },
            {
                "label": "Intermediario",
                "value": "false",
                "displayToAgent": true
            },
            {
                "label": "Número de Identificación Proveedor",
                "transcriptFields": ["NumIdProv__c"],
                "displayToAgent": true
            }

        ];
        embedded_svc.settings.extraPrechatInfo = [

            {
                "entityFieldMaps": [
                    {
                        "doCreate": false,
                        "doFind": false,
                        "fieldName": "LastName",
                        "isExactMatch": true,
                        "label": "Apellidos"
                    },
                    {
                        "doCreate": false,
                        "doFind": false,
                        "fieldName": "FirstName",
                        "isExactMatch": true,
                        "label": "Nombre"
                    },
                    {
                        "doCreate": false,
                        "doFind": false,
                        "fieldName": "Email",
                        "isExactMatch": true,
                        "label": "Correo electrónico"
                    }],
                "entityName": "Contact",
                "saveToTranscript": "Contact",
                "showOnCreate": true
            },

            {
                'entityName': 'Account',
                'showOnCreate': true,
                'saveToTranscript': 'AccountId',
                'entityFieldMaps': [{
                    'isExactMatch': true,
                    'fieldName': 'Tipo_de_identificacion__c',
                    'doCreate': false,
                    'doFind': true,
                    'label': 'Tipo identificación'
                }, {
                    'isExactMatch': true,
                    'fieldName': 'Numero_de_identificacion__c',
                    'doCreate': false,
                    'doFind': true,
                    'label': 'Número de identificación'
                }, {
                    'isExactMatch': true,
                    'fieldName': 'LGM_Pais__c',
                    'doCreate': false,
                    'doFind': true,
                    'label': 'Pais'
                },
                {
                    'isExactMatch': true,
                    'fieldName': 'Intermediario__c',
                    'doCreate': false,
                    'doFind': true,
                    'label': 'Intermediario'
                }
                ]
            },

            {
                'entityName': 'Proveedores_Medicos__c',
                'showOnCreate': true,
                'saveToTranscript': 'Proveedor__c',
                'entityFieldMaps': [{
                    'isExactMatch': true,
                    'fieldName': 'Numero_de_identificacion__c',
                    'doCreate': false,
                    'doFind': true,
                    'label': 'Número de Identificación Proveedor'
                }]
            },
            {
                "entityName": "LiveChatTranscriptFile__c",
                "saveToTranscript": "Archivo_Transcript__c",
                "showOnCreate": false,
                "entityFieldMaps": [{
                    "isExactMatch": true,
                    "fieldName": "Origen__c",
                    "doCreate": true,
                    "doFind": false,
                    "label": "Origin"
                }]
            }
        ];

        embedded_svc.init(
            'https://libertysegurosandinomarket--qa.cs9.my.salesforce.com',
            'https://qa-encuestaslibertyseguros.cs9.force.com/prechat',
            gslbBaseURL,
            '00DK000000WfdT4',
            'ChatSaludEcuador',
            {
                baseLiveAgentContentURL: 'https://c.la3-c1cs-dfw.salesforceliveagent.com/content',
                deploymentId: '5724A0000000vSr',
                buttonId: '573K00000008R7u',
                baseLiveAgentURL: 'https://d.la3-c1cs-dfw.salesforceliveagent.com/chat',
                eswLiveAgentDevName: 'EmbeddedServiceLiveAgent_Parent04IK00000008PflMAE_1709da13be5',
                isOfflineSupportEnabled: false
            }
        );
    };

    if (!window.embedded_svc) {
        var s = document.createElement('script');
        s.setAttribute('src', 'https://libertysegurosandinomarket--qa.cs9.my.salesforce.com/embeddedservice/5.0/esw.min.js');
        s.onload = function () {
            initESW(null);
        };
        document.body.appendChild(s);
    } else {
        initESW('https://service.force.com');
    }
</script>
EOT;
  }

}
