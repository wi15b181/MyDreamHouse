using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using SharedLibrary;
using SharedLibrary.Entities;
using SynchronisationLib.SynchronisationService;

namespace SynchronisationLib
{
    class WebServiceConnector
    {
        SynchronisationWCFClient client = new SynchronisationService.SynchronisationWCFClient();

        public WebServiceConnector()
        {

        }

        public void SendChanges(HauspaketDTO hauspaket)
        {

            client.SaveHauspaket(hauspaket);
        }

        public SyncDataSet FullSync()
        {
            return client.Synchronize("", "");
        }

        public int Ping()
        {
            return client.Ping();
        }

        internal void SendChanges(HauspaketEntity hausPaket, List<AttachmentsEntity> attach, List<HauspaketAttributZuordEntity> zuords, string syncOperation)
        {
            HauspaketDTO dto =
                new HauspaketDTO()
                {
                    Archived = (hausPaket.Archived == false ? "0" : (hausPaket.Archived == true ? "1" : "0")),
                    BenutzerId = hausPaket.BenutzerId,
                    BeraterId = hausPaket.BeraterId,
                    Bezeichnung = hausPaket.Bezeichnung,
                    Grundflaeche = Convert.ToDouble(hausPaket.Grundflaeche),
                    HauspaketId = hausPaket.HauspaketId,
                    HerstellerId = hausPaket.HerstellerId,
                    Preis = Convert.ToDouble(hausPaket.Preis),
                    Stockwerke = hausPaket.Stockwerke,
                    Wohnflaeche = Convert.ToDouble(hausPaket.Wohnflaeche),
                    SyncOperation = syncOperation
                };
            foreach (var item in attach)
            {
                dto.HauspaketAttachements = new List<Attachements>();
                dto.HauspaketAttachements.Add(new Attachements()
                {
                    AttachementId = item.AttachementId,
                    Bezeichnung = item.Bezeichnung,
                    Filename = item.Filename,
                    HauspaketId = item.HauspaketId,
                    Mimetype = item.Mimetype,
                    Size = item.Size,
                    SyncOperation = syncOperation
                });
            }
            foreach (var item in zuords)
            {
                dto.HauspaketAttributZuordnungen = new List<HauspaketAttributZuord>();
                dto.HauspaketAttributZuordnungen.Add(new HauspaketAttributZuord()
                {
                    HauspaketId = item.HauspaketId,
                    WertId = item.WertId,
                    SyncOperation = syncOperation
                });
            }
            client.SaveHauspaket(dto);
        }
    }
}
