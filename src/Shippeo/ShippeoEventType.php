<?php

declare(strict_types=1);

namespace BayWaReLusy\Shippeo;

enum ShippeoEventType: string
{
    case EtaUpdate                                          = 'eta_update';
    case ExternalEtaUpdate                                  = 'external_eta_update';
    case ContainerLeftEmptyPortOfLoading                    = 'container_left_empty_port_of_loading';
    case ContainerLeftEmptyPortOfLoadingEstimated           = 'container_left_empty_port_of_loading_estimated';
    case ContainerEntersFullAtThePortOfLoading              = 'container_enters_full_at_the_port_of_loading';
    case ContainerEntersFullAtThePortOfLoadingEstimated     = 'container_enters_full_at_the_port_of_loading_estimated';
    case ContainerLoadedOnTheBoat                           = 'container_loaded_on_the_boat';
    case ContainerLoadedOnTheBoatEstimated                  = 'container_loaded_on_the_boat_estimated';
    case VesselLeftThePortOfLoading                         = 'vessel_left_the_port_of_loading';
    case VesselLeftThePortOfLoadingEstimated                = 'vessel_left_the_port_of_loading_estimated';
    case VesselArrivedAtTranshipment                        = 'vessel_arrived_at_transhipment';
    case VesselArrivedAtTranshipmentEstimated               = 'vessel_arrived_at_transhipment_estimated';
    case ContainerUnloadedAtTranshipment                    = 'container_unloaded_at_transhipment';
    case ContainerUnloadedAtTranshipmentEstimated           = 'container_unloaded_at_transhipment_estimated';
    case ContainerLoadedAtTranshipment                      = 'container_loaded_at_transhipment';
    case ContainerLoadedAtTranshipmentEstimated             = 'container_loaded_at_transhipment_estimated';
    case VesselDepartedFromTranshipment                     = 'vessel_departed_from_transhipment';
    case VesselDepartedFromTranshipmentEstimated            = 'vessel_departed_from_transhipment_estimated';
    case VesselEntersAtThePortOfDelivery                    = 'vessel_enters_at_the_port_of_delivery';
    case VesselEntersAtThePortOfDeliveryEstimated           = 'vessel_enters_at_the_port_of_delivery_estimated';
    case ContainerUnloadedFromTheVessel                     = 'container_unloaded_from_the_vessel';
    case ContainerUnloadedFromTheVesselEstimated            = 'container_unloaded_from_the_vessel_estimated';
    case ContainerLeftFullThePortOfDelivery                 = 'container_left_full_the_port_of_delivery';
    case ContainerLeftFullThePortOfDeliveryEstimated        = 'container_left_full_the_port_of_delivery_estimated';
    case ContainerReturnsBackEmptyAtThePortOfDelivery       = 'container_returns_back_empty_at_the_port_of_delivery';
    case ContainerReturnsBackEmptyAtThePortOfDeliveryEstimated
    = 'container_returns_back_empty_at_the_port_of_delivery_estimated';

    private const SHIPPEO_EVENT_MAP = [
        'ETA_EVENT'                                                => self::EtaUpdate,
        'ETA_EVENT_EXTERNAL'                                       => self::ExternalEtaUpdate,
        'CONTAINER_EMPTY_GATE_OUT_AT_LOADING_SITE'                 => self::ContainerLeftEmptyPortOfLoading,
        'ORDER_CONTAINER_EMPTY_GATE_OUT_AT_LOADING_SITE_ESTIMATED' => self::ContainerLeftEmptyPortOfLoadingEstimated,
        'CONTAINER_FULL_GATE_IN_AT_LOADING_SITE'                   => self::ContainerEntersFullAtThePortOfLoading,
        'ORDER_CONTAINER_FULL_GATE_IN_AT_LOADING_SITE_ESTIMATED'
            => self::ContainerEntersFullAtThePortOfLoadingEstimated,
        'CONTAINER_LOADED'                                         => self::ContainerLoadedOnTheBoat,
        'ORDER_CONTAINER_LOADED_ESTIMATED'                         => self::ContainerLoadedOnTheBoatEstimated,
        'CONTAINER_LEFT_LOADING_SITE'                              => self::VesselLeftThePortOfLoading,
        'ORDER_CONTAINER_LEFT_LOADING_SITE_ESTIMATED'              => self::VesselLeftThePortOfLoadingEstimated,
        'ORDER_VESSEL_ARRIVED_AT_TRANSHIPMENT'                     => self::VesselArrivedAtTranshipment,
        'ORDER_VESSEL_ARRIVED_AT_TRANSHIPMENT_ESTIMATED'           => self::VesselArrivedAtTranshipmentEstimated,
        'CONTAINER_UNLOADED_TRANSHIPMENT'                          => self::ContainerUnloadedAtTranshipment,
        'ORDER_CONTAINER_UNLOADED_TRANSHIPMENT_ESTIMATED'          => self::ContainerUnloadedAtTranshipmentEstimated,
        'CONTAINER_LOADED_TRANSHIPMENT'                            => self::ContainerLoadedAtTranshipment,
        'ORDER_CONTAINER_LOADED_TRANSHIPMENT_ESTIMATED'            => self::ContainerLoadedAtTranshipmentEstimated,
        'ORDER_VESSEL_DEPARTED_FROM_TRANSHIPMENT'                  => self::VesselDepartedFromTranshipment,
        'ORDER_VESSEL_DEPARTED_FROM_TRANSHIPMENT_ESTIMATED'        => self::VesselDepartedFromTranshipmentEstimated,
        'CONTAINER_ON_DELIVERY_SITE'                               => self::VesselEntersAtThePortOfDelivery,
        'ORDER_CONTAINER_ON_DELIVERY_SITE_ESTIMATED'               => self::VesselEntersAtThePortOfDeliveryEstimated,
        'CONTAINER_UNLOADED'                                       => self::ContainerUnloadedFromTheVessel,
        'ORDER_CONTAINER_UNLOADED_ESTIMATED'                       => self::ContainerUnloadedFromTheVesselEstimated,
        'CONTAINER_FULL_GATE_OUT_AT_DELIVERY_SITE'                 => self::ContainerLeftFullThePortOfDelivery,
        'ORDER_CONTAINER_FULL_GATE_OUT_AT_DELIVERY_SITE_ESTIMATED' => self::ContainerLeftFullThePortOfDeliveryEstimated,
        'CONTAINER_EMPTY_GATE_IN_AT_DELIVERY_SITE'
            => self::ContainerReturnsBackEmptyAtThePortOfDelivery,
        'ORDER_CONTAINER_EMPTY_GATE_IN_AT_DELIVERY_SITE_ESTIMATED'
            => self::ContainerReturnsBackEmptyAtThePortOfDeliveryEstimated,
    ];

    public static function fromShippeoEvent(string $shippeoEvent): self
    {
        return self::SHIPPEO_EVENT_MAP[$shippeoEvent]
            ?? throw new \ValueError("'$shippeoEvent' is not a valid Shippeo event.");
    }
}
