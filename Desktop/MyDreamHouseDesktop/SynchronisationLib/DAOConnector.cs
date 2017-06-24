using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using MyDataModel;
using SharedLibrary;
using SharedLibrary.Entities;
using SynchronisationLib.SynchronisationService;

namespace SynchronisationLib
{
    class DAOConnector
    {
        DataHandler dataHandler;

        public DAOConnector()
        {
            dataHandler = new DataHandler();
        }


        internal List<SyncJnEntity> GetPendingSyncs()
        {
            return dataHandler.GetPendingSyncs();
        }

        internal void UpdateSyncJournal(SyncJnEntity ent)
        {
            dataHandler.UpdateSyncJournal(ent);
        }

        internal HauspaketEntity GetHauspaket(int id)
        {
            return dataHandler.GetHauspaket(id);
        }

        internal List<AttachmentsEntity> GetAttachments(int hid)
        {
            return dataHandler.GetAttachments(hid);
        }

        internal List<HauspaketAttributZuordEntity> GetHauspaketAttributZuordnungen(int hid)
        {
            return dataHandler.GetHauspaketAttributZuordnungen(hid);
        }

        internal void SyncHauspaketAttribut(HauspaketAttribut item)
        {
            HauspaketAttributEntity ent = new HauspaketAttributEntity()
            {
                AttributId = Convert.ToInt32(item.AttributId),
                AttributTyp = item.AttributTyp,
                AttributTypAnzeige = item.AttributTypAnzeige
            };
            switch (item.SyncOperation)
            {
                case "INSERT":
                    {
                        dataHandler.InsertHauspaketAttribut(ent);
                    }
                    break;
                case "UPDATE":
                    {
                        dataHandler.UpdateHauspaketAttribut(ent);
                    }
                    break;
                case "DELETE":
                    {
                        dataHandler.DeleteHauspaketAttribut(ent);
                    }
                    break;
            }
        }

        internal void SyncHauspaketAttributRegel(HauspaketAttributRegel item)
        {
            HauspaketAttributRegelEntity ent = new HauspaketAttributRegelEntity()
            {
                RegelAttributLeftId = Convert.ToInt32(item.RegelAttributLeftId),
                RegelAttributRightId = Convert.ToInt32(item.RegelAttributRightId),
                RegelErlaubt = (item.RegelErlaubt == "0" ? false : (item.RegelErlaubt == "1" ? true : false)),
                RegelId = Convert.ToInt32(item.RegelId),
                RegelPreisModifikator = Convert.ToDecimal(item.RegelPreisModifikator)
            };
            switch (item.SyncOperation)
            {

                case "INSERT":
                    {
                        dataHandler.InsertHauspaketAttributRegel(ent);
                    }
                    break;
                case "UPDATE":
                    {
                        dataHandler.UpdateHauspaketAttributRegel(ent);
                    }
                    break;
                case "DELETE":
                    {
                        dataHandler.DeleteHauspaketAttributRegel(ent);
                    }
                    break;
            }
        }

        internal void SyncHauspaketAttributZuord(HauspaketAttributZuord item)
        {
            HauspaketAttributZuordEntity ent = new HauspaketAttributZuordEntity()
            {
                HauspaketId = Convert.ToInt32(item.HauspaketId),
                WertId = Convert.ToInt32(item.WertId)
            };
            switch (item.SyncOperation)
            {

                case "INSERT":
                    {
                        dataHandler.InsertHauspaketAttributZuord(ent);
                    }
                    break;
                case "UPDATE":
                    {
                        dataHandler.UpdateHauspaketAttributZuord(ent);
                    }
                    break;
                case "DELETE":
                    {
                        dataHandler.DeleteHauspaketAttributZuord(ent);
                    }
                    break;
            }
        }

        internal void SyncAttachments(Attachements item)
        {
            AttachmentsEntity ent = new AttachmentsEntity()
            {
                AttachementId = Convert.ToInt32(item.AttachementId),
                Bezeichnung = item.Bezeichnung,
                Filename = item.Filename,
                HauspaketId = Convert.ToInt32(item.HauspaketId),
                Mimetype = item.Mimetype,
                Size = Convert.ToInt32(item.Size)
            };
            switch (item.SyncOperation)
            {

                case "INSERT":
                    {
                        dataHandler.InsertAttachements(ent);
                    }
                    break;
                case "UPDATE":
                    {
                        dataHandler.UpdateAttachements(ent);
                    }
                    break;
                case "DELETE":
                    {
                        dataHandler.DeleteAttachements(ent);
                    }
                    break;
            }
        }

        internal void SyncHauspaket(Hauspaket item)
        {
            HauspaketEntity ent = new HauspaketEntity()
            {
                Archived = (item.Archived == "0" ? false : (item.Archived == "1" ? true : false)),
                BenutzerId = Convert.ToInt32(item.BenutzerId),
                BeraterId = Convert.ToInt32(item.BeraterId),
                Bezeichnung = item.Bezeichnung,
                Grundflaeche = Convert.ToDecimal(item.Grundflaeche),
                HauspaketId = Convert.ToInt32(item.HauspaketId),
                HerstellerId = Convert.ToInt32(item.HerstellerId),
                Preis = Convert.ToDecimal(item.Preis),
                Stockwerke = Convert.ToInt32(item.Stockwerke),
                Wohnflaeche = Convert.ToDecimal(item.Wohnflaeche)
            };
            switch (item.SyncOperation)
            {

                case "INSERT":
                    {
                        dataHandler.InsertHauspaket(ent);
                    }
                    break;
                case "UPDATE":
                    {
                        dataHandler.UpdateHauspaket(ent);
                    }
                    break;
                case "DELETE":
                    {
                        dataHandler.DeleteHauspaket(ent);
                    }
                    break;
            }
        }

        internal void SyncBerater(Berater item)
        {
            BeraterEntity ent = new BeraterEntity()
            {
                BenutzerId = item.BenutzerId,
                BeraterId = Convert.ToInt32(item.BeraterId),
                Bild = item.Bild,
                HerstellerId = item.HerstellerId
            };
            switch (item.SyncOperation)
            {

                case "INSERT":
                    {
                        dataHandler.InsertBerater(ent);
                    }
                    break;
                case "UPDATE":
                    {
                        dataHandler.UpdateBerater(ent);
                    }
                    break;
                case "DELETE":
                    {
                        dataHandler.DeleteBerater(ent);
                    }
                    break;
            }
        }

        internal void SyncHersteller(Hersteller item)
        {
            HerstellerEntity ent = new HerstellerEntity()
            {
                HerstellerId = item.HerstellerId,
                Name = item.Name
            };
            switch (item.SyncOperation)
            {

                case "INSERT":
                    {
                        dataHandler.InsertHersteller(ent);
                    }
                    break;
                case "UPDATE":
                    {
                        dataHandler.UpdateHersteller(ent);
                    }
                    break;
                case "DELETE":
                    {
                        dataHandler.DeleteHersteller(ent);
                    }
                    break;
            }
        }

        internal void SyncHauspaketAttributWert(HauspaketAttributWert item)
        {
            HauspaketAttributWertEntity ent = new HauspaketAttributWertEntity()
            {
                Archived = (item.Archived == "0" ? false : (item.Archived == "1" ? true : false)),
                AttributId = Convert.ToInt32(item.AttributId),
                WertId = Convert.ToInt32(item.WertId),
                WertOrdnung = Convert.ToInt32(item.WertOrdnung),
                WertText = item.WertText
            };
            switch (item.SyncOperation)
            {

                case "INSERT":
                    {
                        dataHandler.InsertHauspaketAttributWert(ent);
                    }
                    break;
                case "UPDATE":
                    {
                        dataHandler.UpdateHauspaketAttributWert(ent);
                    }
                    break;
                case "DELETE":
                    {
                        dataHandler.DeleteHauspaketAttributWert(ent);
                    }
                    break;
            }
        }

        internal void ClearHauspaketAttributZuord()
        {
            dataHandler.ClearHauspaketAttributZuord();
        }
        internal void ClearAttachements()
        {
            dataHandler.ClearAttachements();
        }
        internal void ClearHauspaket()
        {
            dataHandler.ClearHauspaket();
        }
        internal void ClearBerater()
        {
            dataHandler.ClearBerater();
        }
        internal void ClearHersteller()
        {
            dataHandler.ClearHersteller();
        }
        internal void ClearHauspaketAttributRegel()
        {
            dataHandler.ClearHauspaketAttributRegel();
        }
        internal void ClearHauspaketAttributWert()
        {
            dataHandler.ClearHauspaketAttributWert();
        }
        internal void ClearHauspaketAttribut()
        {
            dataHandler.ClearHauspaketAttribut();
        }
    }
}
